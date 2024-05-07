<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function searchDoctors(Request $request): JsonResponse
    {

        $speciality = $request->input('speciality');
        $city = $request->input('city');
        $country = $request->input('country');
        $town = $request->input('town');
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');

        $doctors = User::where('role', 'doctor');

        if ($speciality) {
            $doctors->where('speciality', $speciality);
        }

        if ($city) {
            $doctors->where('city', $city);
        }

        if ($country) {
            $doctors->where('country', $country);
        }

        if ($town) {
            $doctors->where('region', $town);
        }

        if ($firstName) {
            $doctors->where('name', 'like', '%' . $firstName . '%');
        }
        if ($lastName) {
            $doctors->where('name', 'like', '%' . $lastName . '%');
        }

        $results = $doctors->get();

        return response()->json($results);
    }

    /**
     * Envoyer une demande de rendez-vous au médecin.
     *
     * @param int $doctorId
     * @param  Request  $request
     * @return JsonResponse
     */
    public function sendAppointmentRequest(int $doctorId, Request $request): JsonResponse
    {
        $appointment = new Appointment();
        $appointment->doctor_id = $doctorId;
        $appointment->patient_id = Auth::id(); // ID du patient connecté
        $appointment->date = $request->input('date');
        $appointment->time = $request->input('time');
        $appointment->consultation_reason = $request->input('reason');
        $appointment->consultation_type = $request->input('type');
        $appointment->save();

        return response()->json(['message' => 'Demande de rendez-vous envoyée avec succès']);
    }
}
