<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Enums\BloodGroup;
use App\Enums\PatientArea;
use App\Mail\NewUserWelcome;
use App\Models\Appointment;
use App\Models\ConsultationReport;
use App\Models\MedicalRecord;
use App\Models\User;
use App\Services\PatientProfileService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PatientController extends Controller
{
    protected PatientProfileService $patientProfileService;

    public function __construct(PatientProfileService $patientProfileService)
    {
        $this->patientProfileService = $patientProfileService;
    }

    /**
     * @throws AuthorizationException
     */
    public function showPatientDetails($patientId, $appointment_id = null)
    {
        $doctor = Auth::user();
        $doctor_id = $doctor->id;
        $patient = User::findOrFail($patientId);

        if ($appointment_id) {
            $appointment = Appointment::findOrFail($appointment_id);
        } else {
            $appointment = null;
        }
        $patientAppointments = $patient->patientAppointments();
        $appointments = $doctor->doctorAppointments()
            ->where('patient_id', $patientId)
            ->whereNotIn('status', [AppointmentStatus::CANCELLED, AppointmentStatus::REFUSED])
            ->orderBy('start_date', 'desc')
            ->get();

        // Rendez-vous à venir
        $upcomingAppointments = $appointments->filter(function ($appointment) {
            return in_array($appointment->status, [AppointmentStatus::CONFIRMED, AppointmentStatus::STARTED])
                && $appointment->start_date > now();
        });

        // Historique des rendez-vous
        $recentAppointments = $appointments->filter(function ($appointment) {
            return in_array($appointment->status, [AppointmentStatus::COMPLETED])
                || ($appointment->status === AppointmentStatus::CONFIRMED && $appointment->start_date <= now());
        });
        $consultationReports = ConsultationReport::whereHas('appointment', function ($query) use ($patientAppointments) {
            $query->whereIn('id', $patientAppointments->pluck('id'));
        })->orderBy('created_at', 'desc')->paginate(10);

        $this->authorize('view', User::findOrFail($patientId)->medicalRecord);
        $this->authorize('viewAny', [ConsultationReport::class, User::findOrFail($patientId)]);

        $profileData = $this->patientProfileService->getProfileData($patientId, $doctor_id);

        return view('patient.profile',
            array_merge($profileData,
                compact('appointment',
                    'appointments',
                    'upcomingAppointments',
                    'recentAppointments',
                    'consultationReports'
                )
            )
        );
    }

    public function index()
    {
        $patients = User::where('role', 'patient')->get();
        return view('super-admin.patients.index', compact('patients'));
    }

    public function myPatients()
    {
        $user = auth()->user();
        if ($user->role === 'doctor') {
            $doctor = $user;
        } elseif ($user->role === 'assistant') {
            $doctor = $user->doctor;
        }
        $patients = $doctor->patients;
        return view('doctor.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('super-admin.patients.create');
    }

    public function createByDoctor()
    {
        return view('doctor.patients.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if ($user->role === 'doctor') {
            $doctor = $user;
        } elseif ($user->role === 'assistant') {
            $doctor = $user->doctor;
        }
        $validator = Validator::make($request->all(), [
            'lastName' => 'required|string',
            'firstName' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'required|boolean',
            'dob' => 'required|date',
            'phone_number' => 'nullable|string|max:255',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'blood_group' => ['nullable', 'string', Rule::in(BloodGroup::getValues())],
            'smoking' => 'nullable|boolean',
            'alcohol' => 'nullable|boolean',
            'area' => ['nullable', 'string', Rule::in(PatientArea::getValues())],
            'sedentary_lifestyle' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $patient = new User;
        $patient->lastName = $request->lastName;
        $patient->firstName = $request->firstName;
        $patient->email = $request->email;
        $patient->password = Hash::make($request->password);
        $patient->gender = $request->gender;
        $patient->dob = $request->dob;
        $patient->phone_number = $request->phone_number;
        $patient->role = 'patient';
        $patient->save();
        if ($user->role === 'doctor' || $user->role === 'assistant') {
            $doctor->patients()->attach($patient->id);
        }
        $medicalRecord = new MedicalRecord();
        $medicalRecord->patient_id = $patient->id;
        $medicalRecord->height = $request->height ?? null;
        $medicalRecord->weight = $request->weight ?? null;
        $medicalRecord->blood_group = $request->blood_type ?? null;
        $medicalRecord->smoking = $request->smoking ?? null;
        $medicalRecord->alcohol = $request->alcohol ?? null;
        $medicalRecord->area = $request->area ?? null;
        $medicalRecord->sedentary_lifestyle = $request->sedentary_lifestyle ?? null;
        $medicalRecord->save();
        Mail::to($patient->email)->send(new NewUserWelcome($patient));
        return redirect()->back()->with('success', 'Patient ajouté avec succès.');
    }

    public function show($id)
    {
        $patient = User::findOrFail($id);
        return view('super-admin.patients.show', compact('patient'));
    }

    public function edit($id)
    {
        $patient = User::findOrFail($id);
        return view('super-admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'lastName' => 'required|string',
            'firstName' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'gender' => 'required|boolean',
            'phone_number' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Mise à jour des données de l'utilisateur
        $patient = User::findOrFail($id);
        $patient->lastName = $request->lastName;
        $patient->firstName = $request->firstName;
        $patient->email = $request->email;
        $patient->gender = $request->gender;
        $patient->phone_number = $request->phone_number;
        $patient->save();

        return redirect()->back()->with('success', 'Profil patient mis à jour avec succès.');
    }

    public function activate($id)
    {
        $patient = User::findOrFail($id);
        $patient->update(['status' => true]);
        return redirect()->route('patients.index')->with('success', 'Le compte du patient a été activé avec succès.');
    }

    public function deactivate($id)
    {
        $patient = User::findOrFail($id);
        $patient->update(['status' => false]);
        return redirect()->route('patients.index')->with('success', 'Le compte du patient a été désactivé avec succès.');
    }

    public function destroy($id)
    {
        $patient = User::findOrFail($id);
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient supprimé avec succès.');
    }
}
