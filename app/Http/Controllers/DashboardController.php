<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Enums\UserRole;
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
//                $this->authorize('view', $medicalRecord);
                $appointments = Appointment::where('patient_id', $patient_id)->whereNotIn('status', [AppointmentStatus::REFUSED, AppointmentStatus::CANCELLED])->orderBy('start_date', 'desc')->get();
                $upcomingAppointments = $appointments->where('start_date', '>', now());
                $recentAppointments = $appointments->where('start_date', '<=', now());

                $consultationReports = ConsultationReport::whereHas('appointment', function ($query) use ($recentAppointments) {
                    $query->whereIn('id', $recentAppointments->pluck('id'));
                })->paginate(5);
//                $this->authorize('view', $consultationReport);
                $prescriptions = Prescription::whereIn('consultation_report_id', $consultationReports->pluck('id'))
                    ->with('prescriptionLines')
                    ->get();
//                $this->authorize('view', $prescriptions);

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
