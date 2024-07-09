<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Availability;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AppointmentController extends Controller
{

    public function index($doctor_id)
    {
        $doctor = User::find($doctor_id);
        return view('appointment.request', compact('doctor'));
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
        $request->validate([
            'start_date' => 'required|datetime|after_or_equal:now',
            'consultation_reason' => 'required|string|max:255',
            'consultation_type' => 'required|in:Online,In person,Home service',
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
        $doctor = Auth::user();
        $appointments = $doctor->doctorAppointments()->with('patient')->get();
        $pendingAppointments = $appointments->where('status', 'pending');
        $confirmedAppointments = $appointments->where('status', 'confirmed');
        $refusedAppointments = $appointments->where('status', 'refused');
        return view('doctor.myAppointments', compact('appointments', 'pendingAppointments', 'confirmedAppointments', 'refusedAppointments'));
    }

    public function updateStatus(Request $request)
    {
        $doctor = auth()->user();
        $appointment = Appointment::findOrFail($request->appointment_id);
        $availability = Availability::where('doctor_id', $doctor->id)->first();
        $consultationDuration = $availability->consultation_duration;
        $start = Carbon::parse($appointment->start_date);
        $appointment->status = $request->status;
        if ($request->status === 'confirmed') {
            $appointment->finish_date = $start->copy()->addMinutes($consultationDuration);
            if (!$doctor->patients()->where('patient_id', $appointment->patient_id)->exists()) {
                $doctor->patients()->attach($appointment->patient_id);
            }
            $appointment->save();
        }
        $appointment->save();
        switch ($appointment->status) {
            case ('confirmed'):
                $message = 'Rendez-vous confirmé';
                break;
            case ('refused'):
                $message = 'Rendez-vous réfusé';
                break;
            case ('cancelled'):
                $message = 'Rendez-vous annulé';
                break;
            default:
                $message = "";
                break;
        }
        return back()->with(['success' => $message, 'status' => $appointment->status]);

    }
}
