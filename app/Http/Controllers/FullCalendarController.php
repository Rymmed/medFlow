<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Availability;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class FullCalendarController extends Controller
{
    public function index(): View
    {
        $doctor = auth()->user();
        $patients = $doctor->patients()->get();
        return view('doctor.myCalendar', compact('patients'));
    }

    public function getAppointments(): JsonResponse
    {
        $events = [];
        $appointments = Appointment::where('doctor_id', Auth()->user()->id)
            ->where('status', 'confirmed')
            ->get();

        foreach ($appointments as $appointment) {
            $events[] = [
                'id' => $appointment->id,
                'title' => $appointment->patient->firstName . ' ' . $appointment->patient->lastName,
                'start' => $appointment->start_date,
                'end' => $appointment->finish_date,
                'consultation_type' => $appointment->consultation_type,
                'consultation_reason' => $appointment->consultation_reason,
                'patient_firstName' => $appointment->patient->firstName,
                'patient_lastName' => $appointment->patient->lastName,
            ];
        }
        return response()->json($events);
    }

    public function cancelAppointment($id): JsonResponse
    {
        $appointment = Appointment::findOrFail($id);
        if ($appointment) {
            $appointment->status = 'cancelled';
            $appointment->save();

            return response()->json(['message' => 'Rendez-vous annulé avec succès']);
        }
        return response()->json(['message' => 'Erreur d\'annulation du Rendez-vous']);
    }

    public function createAppointment(Request $request): JsonResponse
    {
        $doctor = auth()->user();
        $doctor_id = $doctor->id;
        $request->validate([
            'start_date' => 'required|datetime|after_or_equal:now',
            'consultation_duration' => 'numeric|min:1',
            'consultation_type' => 'required|in:Online,In person,Home service',
        ]);

        if ($request->patient_id === 'new') {
            $patient = User::create([
                'firstName' => $request->new_patient_firstName,
                'lastName' => $request->new_patient_lastName,
                'role' => 'patient',
            ]);

            $doctor->patients()->attach($patient->id);
        } else {
            $patient = User::find($request->patient_id);

            if (!$doctor->patients()->where('patient_id', $patient->id)->exists()) {
                $doctor->patients()->attach($patient->id);
            }
        }
        $availability = Availability::where('doctor_id', $doctor_id);
        $consultationDuration = $request->consultation_duration;
        $defaultDuration = $availability->consultation_duration;;
        $start = Carbon::parse($request->start_date);
        $appointment = Appointment::create([
            'doctor_id' => $doctor_id,
            'patient_id' => $request->patient_id,
            'start_date' => $request->start_date,
            'finish_date' => $consultationDuration ? $start->copy()->addMinutes($consultationDuration): $start->copy()->addMinutes($defaultDuration),
            'consultation_type' => $request->consultation_type,
            'status' => 'confirmed',
        ]);
        return response()->json(['message' => 'Rendez-vous créé avec succès', 'event' => $appointment]);
    }

    public function updateAppointment(Request $request, $id): JsonResponse
    {
        $appointment = Appointment::findOrFail($id);

        $existingStartDate = Carbon::parse($appointment->start_date);
        $existingFinishDate = Carbon::parse($appointment->finish_date);

        $newStartDate = Carbon::parse($request->input('start_date'));
        $newFinishDate = Carbon::parse($request->input('finish_date'));

        $updatedStartDate = Carbon::create(
            $newStartDate->year,
            $newStartDate->month,
            $newStartDate->day,
            $existingStartDate->hour,
            $existingStartDate->minute,
            $existingStartDate->second
        );

        $updatedFinishDate = Carbon::create(
            $newFinishDate->year,
            $newFinishDate->month,
            $newFinishDate->day,
            $existingFinishDate->hour,
            $existingFinishDate->minute,
            $existingFinishDate->second
        );
        $appointment->update([
            'start_date' => $updatedStartDate,
            'finish_date' => $updatedFinishDate,
        ]);
        return response()->json(['message' => 'Rendez-vous mis à jour avec succès']);
    }
}
