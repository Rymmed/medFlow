<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
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
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'consultation_reason' => 'required|string|max:255',
            'consultation_type' => 'required|in:En ligne,En présentiel,Service à domicile',
        ]);
        $appointmentDate = $request->date;
        $appointmentTime = $request->time;

        if ($doctor->isAvailable($appointmentDate, $appointmentTime)) {
            $appointment = Appointment::create([
                'patient_id' => Auth::user()->id,
                'doctor_id' => $doctor_id,
                'date' => $appointmentDate,
                'time' => $appointmentTime,
                'consultation_reason' => $request->consultation_reason,
                'consultation_type' => $request->consultation_type,
            ]);

            return redirect()->back()->with('success', 'La demande de rendez-vous a été envoyée avec succès.');
        } else {
            return redirect()->back()->with('error', 'Le médecin n\'est pas disponible! S\'il vous plait choisir une autre date.');
        }
    }

    public function myAppointments() : View
    {
        $doctor = Auth::user();
        $appointments = $doctor->doctorAppointments()->with('patient')->get();
        $pendingAppointments = $appointments->where('status', 'pending');
        $confirmedAppointments = $appointments->where('status', 'confirmed');

        return view('doctor.myAppointments', compact('appointments', 'pendingAppointments', 'confirmedAppointments'));
    }

    public function updateStatus(Request $request)
    {
        $appointment = Appointment::find($request->id);

        if ($appointment) {
            $appointment->status = $request->status;
            $appointment->save();

            return response()->json(['success' => true, 'status' => $appointment->status]);
        }

        return response()->json(['success' => false]);
    }
    public function calendar($doctor_id)
    {
        $appointments = Appointment::where('doctor_id', $doctor_id)
            ->where('status', 'confirmed')
            ->get(['id', 'title', 'start', 'end']);

        return response()->json($appointments);
    }
}
