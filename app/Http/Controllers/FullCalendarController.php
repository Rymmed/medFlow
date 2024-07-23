<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\DoctorInfo;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
            ->where('status', AppointmentStatus::CONFIRMED)
            ->get();

        foreach ($appointments as $appointment) {
            $events[] = [
                'id' => $appointment->id,
                'title' => $appointment->patient->firstName . ' ' . $appointment->patient->lastName,
                'start' => $appointment->start_date,
                'end' => $appointment->finish_date,
                'consultation_duration' => $appointment->doctor()->first()->doctor_info()->first()->consultation_duration,
                'consultation_type' => $appointment->consultation_type,
                'consultation_reason' => $appointment->consultation_reason,
                'patient_id' => $appointment->patient->id,
            ];
        }
        return response()->json($events);
    }

    public function cancelAppointment($id): JsonResponse
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = AppointmentStatus::CANCELLED;
        $appointment->save();
        return response()->json(['success' => true, 'message' => 'Rendez-vous annulé avec succès']);
    }


    public function createAppointment(Request $request): JsonResponse
    {
        $doctor = auth()->user();
        $doctor_id = $doctor->id;
        $request->validate([
            'start_date' => 'required|date|after_or_equal:now',
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
        $doctorInfo = DoctorInfo::where('doctor_id', $doctor_id)->first();
        $consultationDuration = $request->consultation_duration;
        $defaultDuration = $doctorInfo->consultation_duration;
        var_dump($defaultDuration);
        $start = Carbon::parse($request->start_date);
        $appointment = Appointment::create([
            'doctor_id' => $doctor_id,
            'patient_id' => $request->patient_id,
            'start_date' => $request->start_date,
            'finish_date' => $consultationDuration ? $start->copy()->addMinutes($consultationDuration) : $start->copy()->addMinutes($defaultDuration),
            'consultation_type' => $request->consultation_type,
            'status' => AppointmentStatus::CONFIRMED,
        ]);
        return response()->json(['success' => true, 'message' => 'Rendez-vous créé avec succès', 'event' => $appointment]);
    }

    public function dropAppointment(Request $request, $id): JsonResponse
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
        return response()->json(['success' => true, 'message' => 'Rendez-vous déplacé avec succès']);
    }

    public function updateAppointment(Request $request, $id): JsonResponse
    {
        $appointment = Appointment::findOrFail($id);
        $request->validate([
            'update-start_date' => 'required|date|after_or_equal:now',
            'update-finish_date' => 'required|date|after:update-start_date',
        ]);
        $newStartDate = Carbon::parse($request->input('update-start_date'));
        $newFinishDate = Carbon::parse($request->input('update-finish_date'));
        $consultation_type = $request->input('update-consultation_type');

        $appointment->update([
            'start_date' => $newStartDate,
            'finish_date' => $newFinishDate,
            'consultation_type' => $consultation_type,
        ]);
        return response()->json(['success' => true, 'message' => 'Rendez-vous mis à jour avec succès']);

    }
}
