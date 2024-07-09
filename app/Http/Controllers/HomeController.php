<?php

namespace App\Http\Controllers;

use App\Models\Allergy;
use App\Models\Appointment;
use App\Models\ConsultationReport;
use App\Models\ExamResult;
use App\Models\MedicalHistory;
use App\Models\Prescription;
use App\Models\Vaccination;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            case ("super-admin"):
                return view('super-admin.home');
                break;
            case "admin":
                return view('admin.home');
                break;
            case "doctor":
                return view('doctor.home');
                break;
            case "patient":
                $user = auth()->user();
                $doctors = $user->doctors;
                $medications = Prescription::whereHas('consultationReport', function ($query) use ($user) {
                    $query->where('patient_id', $user->id);
                })->with('prescriptionLines')->get();
                $allergies = Allergy::where('patient_id', $user->id)->get();
                $medicalHistories = MedicalHistory::where('patient_id', $user->id)->get();
                $vaccinations = Vaccination::where('patient_id', $user->id)->get();
                $upcomingAppointments = Appointment::where('patient_id', $user->id)->where('start_date', '>', now())->get();
                $recentAppointments = Appointment::where('patient_id', $user->id)->where('start_date', '<=', now())->get();
//                dd($recentAppointments);
                $consultationReports = ConsultationReport::where('patient_id', $user->id)->get();
                $examResults = ExamResult::where('patient_id', $user->id)->get();

                return view('patient.home', compact(
                    'doctors',
                    'medications',
                    'allergies',
                    'medicalHistories',
                    'vaccinations',
                    'upcomingAppointments',
                    'recentAppointments',
                    'consultationReports',
                    'examResults'
                ));
                break;
            case "assistant":
                return view('assistant.home');
                break;
            default:
                Auth::logout();
                return view('/login')->with('error', 'oops something went wrong');
        }
    }
}
