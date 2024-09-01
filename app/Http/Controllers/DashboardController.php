<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Enums\UserRole;
use App\Models\Appointment;
use App\Models\ConsultationReport;
use App\Models\MedicalRecord;
use App\Models\Prescription;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\In;

class DashboardController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $user_role = Auth::user()->role;
        switch ($user_role) {
            case UserRole::SUPER_ADMIN:
                return view('super-admin.dashboard');
                break;
            case UserRole::ADMIN:
                return view('admin.dashboard');
                break;
            case UserRole::DOCTOR:
                $doctor = auth()->user();
                $appointments = Appointment::where('doctor_id', $doctor->id)->with('patient')->get();
                return view('doctor.dashboard', compact('appointments'));
                break;
            case UserRole::PATIENT:
                $patient = auth()->user();
                $patient_id = $patient->id;
                $doctors = $patient->doctors;

                $medicalRecord = MedicalRecord::where('patient_id', $patient_id)->first();

                // Récupérer tous les rendez-vous du patient
                $appointments = $patient->patientAppointments()
                    ->whereNotIn('status', [AppointmentStatus::CANCELLED, AppointmentStatus::REFUSED, AppointmentStatus::PENDING, AppointmentStatus::PENDING_RESCHEDULE])
                    ->orderBy('start_date', 'desc')
                    ->paginate(5);

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

                $consultationReports = ConsultationReport::whereHas('appointment', function ($query) use ($patient) {
                    $query->where('patient_id', $patient->id);
                })->orderBy('created_at', 'desc')->paginate(5);

                $prescriptions = Prescription::where('medicalRecord_id', $medicalRecord->id)
                    ->with('prescriptionLines')
                    ->orderBy('created_at', 'desc')
                    ->paginate(2);

                return view('patient.dashboard', compact(
                    'doctors',
                    'consultationReports',
                    'medicalRecord',
                    'appointments',
                    'upcomingAppointments',
                    'recentAppointments',
                    'prescriptions'
                ));
                break;
            case UserRole::ASSISTANT:
                return view('assistant.dashboard');
                break;
            default:
                Auth::logout();
                return view('/login')->with('error', 'oops something went wrong');
        }
    }
}
