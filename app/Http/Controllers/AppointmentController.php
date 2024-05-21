<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{

    public function index($doctor_id)
    {
        return view('appointment.request', compact('doctor_id'));
    }

    /**
     * Envoyer une demande de rendez-vous au médecin.
     *
     * @param int $doctorId
     * @param Request $request
     * @return RedirectResponse
     */
    public function sendAppointmentRequest(Request $request): RedirectResponse
    {
        $doctor_id = $request->doctor_id;
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'start_date' => 'required|date|after_or_equal:today',
            'finish_date' => 'required|date|after:start_date',
            'consultation_reason' => 'required|string|max:255',
            'consultation_type' => 'required|in:En ligne,En présentiel,Service à domicile',
        ]);

        $appointment = Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $doctor_id,
            'start_date' => $request->start_date,
            'finish_date' => $request->finish_date,
            'consultation_reason' => $request->consultation_reason,
            'consultation_type' => $request->consultation_type,
            'status' => 'En attente',
        ]);
        return redirect()->back()->with('success', 'La demande de rendez-vous a été envoyée avec succès.');
    }

}
