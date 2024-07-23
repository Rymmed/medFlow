<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Allergy;
use App\Models\Appointment;
use App\Models\ConsultationReport;
use App\Models\ExamResult;
use App\Models\Insurance;
use App\Models\MedicalHistory;
use App\Models\MedicalRecord;
use App\Models\Prescription;
use App\Models\Vaccination;
use App\Models\VitalSign;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\In;

class HomeController extends Controller
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
                return view('super-admin.home');
                break;
            case UserRole::ADMIN:
                return view('admin.home');
                break;
            case UserRole::DOCTOR:
                return view('doctor.home');
                break;
            case UserRole::PATIENT:
                $patient = auth()->user();
                $patient_id = $patient->id;
                $doctors = $patient->doctors;

                $medicalRecord = MedicalRecord::where('patient_id', $patient_id)->first();
                $medicalRecord_id = $medicalRecord->id;
                $vital_signs = VitalSign::where('medicalRecord_id', $medicalRecord_id)->get();
                $medicalHistories = MedicalHistory::where('medicalRecord_id', $medicalRecord_id)->get();
                $vaccinations = Vaccination::where('medicalRecord_id', $medicalRecord_id)->get();
                $examResults = ExamResult::where('medicalRecord_id', $medicalRecord_id)->get();
                $insuranceDetails = Insurance::where('medicalRecord_id', $medicalRecord_id)->first();
                $appointments = Appointment::where('patient_id', $patient_id)->whereNotIn('status', ['refused', 'cancelled'])->orderBy('start_date', 'desc')->get();
                $upcomingAppointments = $appointments->where('start_date', '>', now());
                $recentAppointments = $appointments->where('start_date', '<=', now());
                $consultationReports = ConsultationReport::whereHas('appointment', function ($query) use ($patient_id, $patient) {
                    $query->where('patient_id', $patient_id);
                })->paginate(5);
                $prescriptions = Prescription::whereHas('consultationReport.appointment', function ($query) use ($patient_id) {
                    $query->where('patient_id', $patient_id);
                })->with('prescriptionLines')->get();

                return view('patient.home', compact(
                    'doctors',
                    'medicalRecord',
                    'vital_signs',
                    'medicalHistories',
                    'vaccinations',
                    'examResults',
                    'insuranceDetails',
                    'appointments',
                    'upcomingAppointments',
                    'recentAppointments',
                    'consultationReports',
                    'prescriptions'
                ));
                break;
            case UserRole::ASSISTANT:
                return view('assistant.home');
                break;
            default:
                Auth::logout();
                return view('/login')->with('error', 'oops something went wrong');
        }
    }
}
