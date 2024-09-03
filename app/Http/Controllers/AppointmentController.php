<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Mail\AppointmentCanceledByPatientMail;
use App\Mail\AppointmentCanceledMail;
use App\Mail\AppointmentConfirmedMail;
use App\Mail\AppointmentRefusedMail;
use App\Mail\AppointmentRescheduleMail;
use App\Models\Appointment;
use App\Models\DoctorInfo;
use App\Models\User;
use App\Services\AppointmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    public function index()
    {
        $patient = auth()->user();
        $appointments = $patient->patientAppointments()
            ->whereIn('status', [AppointmentStatus::CONFIRMED, AppointmentStatus::STARTED, AppointmentStatus::COMPLETED])
            ->orderBy('start_date', 'desc')
            ->get();

        // Rendez-vous à venir
        $upcomingAppointments = $appointments->filter(function ($appointment) {
            return in_array($appointment->status, [AppointmentStatus::CONFIRMED, AppointmentStatus::STARTED])
                && $appointment->start_date > now();
        });

        // Historique des rendez-vous (completés, annulés, refusés)
        $oldAppointments = $appointments->filter(function ($appointment) {
            return in_array($appointment->status, [AppointmentStatus::COMPLETED, AppointmentStatus::CANCELLED, AppointmentStatus::REFUSED])
                || ($appointment->status === AppointmentStatus::CONFIRMED && $appointment->start_date <= now());
        });

        // Paginer les collections manuellement
        $upcomingAppointments = $this->appointmentService->paginate($upcomingAppointments, 10, 'upcoming_page');
        $oldAppointments = $this->appointmentService->paginate($oldAppointments, 10, 'old_page');
        $appointments = $this->appointmentService->paginate($appointments, 10, 'all_page');

        return view('patient.appointments', compact(
            'appointments',
            'upcomingAppointments',
            'oldAppointments'
        ));
    }

    public function requestForm($doctor_id)
    {
        $doctor = User::find($doctor_id);
        $doctor_info = DoctorInfo::where('doctor_id', $doctor->id)->first();
        $consultation_types = json_decode($doctor_info->consultation_types, true);
        return view('appointment.request', compact('doctor', 'doctor_info', 'consultation_types'));
    }

    /**
     *
     * @param Request $request
     * @param $doctor_id
     * @return RedirectResponse
     */
    public function sendAppointmentRequest(Request $request, $doctor_id): RedirectResponse
    {
        $doctor = User::find($doctor_id);
        $doctorInfo = DoctorInfo::where('doctor_id', $doctor->id)->first();
        $consultationTypes = json_decode($doctorInfo->consultation_types);
        $request->validate([
            'start_date' => 'required|date|after_or_equal:now',
            'consultation_reason' => 'required|string|max:255',
            'consultation_type' => ['required', Rule::in($consultationTypes)],
        ]);

        $appointmentStartDate = $request->start_date;
        $availabilityCheck = $doctor->isAvailable($appointmentStartDate);
        if (!$availabilityCheck['isAvailable']) {
            return back()->withErrors($availabilityCheck['errors']);
        }
        $appointment = Appointment::create([
            'patient_id' => Auth::id(),
            'doctor_id' => $doctor_id,
            'start_date' => $appointmentStartDate,
            'consultation_reason' => $request->consultation_reason,
            'consultation_type' => $request->consultation_type,
        ]);
        return back()->with('success', 'La demande de rendez-vous a été envoyée avec succès.');
    }

    public function myAppointments(): View
    {
        $user = auth()->user();
        if ($user->role === 'doctor') {
            $doctor = $user;
        } elseif ($user->role === 'assistant') {
            $doctor = $user->doctor;
        }
        $pending = AppointmentStatus::PENDING;
        $reschedule = AppointmentStatus::PENDING_RESCHEDULE;
        $confirmed = AppointmentStatus::CONFIRMED;
        $refused = AppointmentStatus::REFUSED;
        $appointments = $doctor->doctorAppointments()->with('patient')->get();
        $pendingAppointments = $appointments->where('status', $pending);
        $rescheduleAppointments = $appointments->where('status', $reschedule);
        $confirmedAppointments = $appointments->where('status', $confirmed);
        $refusedAppointments = $appointments->where('status', $refused);
        $patients = $doctor->patients;
        return view('doctor.myAppointments',
            compact(
                'appointments',
                'pendingAppointments',
                'rescheduleAppointments',
                'confirmedAppointments', 'refusedAppointments',
                'patients'
            )
        );
    }

    public function updateStatus(Request $request)
    {
        $user = auth()->user();
        if ($user->role === 'doctor') {
            $doctor = $user;
        } elseif ($user->role === 'assistant') {
            $doctor = $user->doctor;
        }
        $cancelled = AppointmentStatus::CANCELLED;
        $confirmed = AppointmentStatus::CONFIRMED;
        $refused = AppointmentStatus::REFUSED;
        $appointment = Appointment::findOrFail($request->appointment_id);
        $doctorInfo = DoctorInfo::where('doctor_id', $doctor->id)->firstOrFail();
        $consultationDuration = $doctorInfo->consultation_duration;
        $start = Carbon::parse($appointment->start_date);
        $appointment->status = $request->status;
        if ($request->status === $confirmed) {
            $appointment->finish_date = $start->copy()->addMinutes($consultationDuration);
            if (!$doctor->patients()->where('patient_id', $appointment->patient_id)->exists()) {
                $doctor->patients()->attach($appointment->patient_id);
            }
            $appointment->save();
        }
        $appointment->save();
        switch ($appointment->status) {
            case ($confirmed):
                $message = 'Rendez-vous confirmé';
                Mail::to($appointment->patient->email)->send(new AppointmentConfirmedMail($appointment));
                break;
            case ($refused):
                $message = 'Rendez-vous réfusé';
                Mail::to($appointment->patient->email)->send(new AppointmentRefusedMail($appointment));
                break;
            case ($cancelled):
                $message = 'Rendez-vous annulé';
                Mail::to($appointment->patient->email)->send(new AppointmentCanceledMail($appointment));
                break;
            default:
                $message = "";
                break;
        }
        return back()->with(['success' => $message, 'status' => $appointment->status]);
    }

    public function updateAppointment(Request $request, $id): RedirectResponse
    {
        $appointment = $this->appointmentService->update($request, $id);
        return back()->with(['success' => 'Rendez-vous mis à jour avec succès']);
    }

    /**
     * Allow the patient to cancel or request to reschedule an appointment.
     *
     * @param Request $request
     * @param int $appointment_id
     * @return RedirectResponse
     */
    public function requestRescheduleOrCancel(Request $request, $appointment_id): RedirectResponse
    {
        $appointment = Appointment::findOrFail($appointment_id);

        // Check if the appointment belongs to the authenticated patient
        if ($appointment->patient_id !== Auth::id()) {
            return back()->withErrors('Vous ne pouvez pas modifier ce rendez-vous.');
        }

        $request->validate([
            'action' => 'required|string|in:cancel,reschedule',
            'new_date' => 'required_if:action,reschedule|date|after:now',
        ]);

        $doctor = $appointment->doctor;
        $action = $request->action;

        if ($action === 'cancel') {
            $appointment->status = AppointmentStatus::CANCELLED;
            $appointment->save();
            Mail::to($doctor->email)->send(new AppointmentCanceledByPatientMail($appointment));

            return back()->with('success', 'Votre rendez-vous a été annulé.');
        } elseif ($action === 'reschedule') {
            $newDate = $request->new_date;
            $availabilityCheck = $doctor->isAvailable($newDate);

            if (!$availabilityCheck['isAvailable']) {
                return back()->withErrors($availabilityCheck['errors']);
            }

            $oldDate = $appointment->start_date;
            $appointment->start_date = $request->new_date;
            $appointment->status = AppointmentStatus::PENDING_RESCHEDULE;
            $appointment->save();
            Mail::to($doctor->email)->send(new AppointmentRescheduleMail($appointment, $oldDate));

            return back()->with('success', 'Votre demande de report de rendez-vous a été envoyée.');
        }

        return back()->withErrors('Action non valide.');
    }

    public function getRequests()
    {
        $patient = auth()->user();
        $appointments = $patient->patientAppointments()
            ->orderBy('start_date', 'desc')
            ->get();

        $refusedRequests = $appointments->filter(function ($appointment) {
            return $appointment->status === AppointmentStatus::REFUSED;
        });
        $canceledRequests = $appointments->filter(function ($appointment) {
            return $appointment->status === AppointmentStatus::CANCELLED;
        });

        // Demandes de rendez-vous en attente
        $pendingRequests = $appointments->filter(function ($appointment) {
            return $appointment->status === AppointmentStatus::PENDING;
        });

        // Demandes de report de rendez-vous
        $reportedRequests = $appointments->filter(function ($appointment) {
            return $appointment->status === AppointmentStatus::PENDING_RESCHEDULE;
        });

        $refusedRequests = $this->appointmentService->paginate($refusedRequests, 10, 'refused_page');
        $canceledRequests = $this->appointmentService->paginate($canceledRequests, 10, 'canceled_page');
        $pendingRequests = $this->appointmentService->paginate($pendingRequests, 10, 'pending_page');
        $reportedRequests = $this->appointmentService->paginate($reportedRequests, 10, 'reported_page');
        return view('patient.requests', compact(
            'refusedRequests',
            'canceledRequests',
            'pendingRequests',
            'reportedRequests'
        ));
    }
}
