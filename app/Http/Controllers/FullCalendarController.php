<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Mail\AppointmentCanceledMail;
use App\Mail\AppointmentConfirmedMail;
use App\Mail\AppointmentUpdatedMail;
use App\Models\Appointment;
use App\Models\DoctorInfo;
use App\Models\User;
use App\Services\AppointmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class FullCalendarController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }
    public function index(): View
    {
        $user = auth()->user();
        if ($user->role === 'doctor') {
            $doctor = $user;
        } elseif ($user->role === 'assistant') {
            $doctor = $user->doctor;
        }
        $patients = $doctor->patients()->get();
        return view('doctor.myCalendar', compact('patients'));
    }

    public function getAppointments(): JsonResponse
    {
        $events = [];
        $user = auth()->user();
        if ($user->role === 'doctor') {
            $doctor = $user;
        } elseif ($user->role === 'assistant') {
            $doctor = $user->doctor;
        }
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->where('status', AppointmentStatus::CONFIRMED)
            ->get();

        foreach ($appointments as $appointment) {
            $start = Carbon::parse($appointment->start_date);
            $doctorInfo = DoctorInfo::where('doctor_id', $appointment->doctor->id)->first();
            $defaultDuration = $doctorInfo->consultation_duration;
            $events[] = [
                'id' => $appointment->id,
                'title' => $appointment->patient->firstName . ' ' . $appointment->patient->lastName,
                'start' => $appointment->start_date,
                'end' => $appointment->finish_date ?: $start->copy()->addMinutes($defaultDuration),
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
        Mail::to($appointment->patient->email)->send(new AppointmentCanceledMail($appointment));
        return response()->json(['success' => true, 'message' => 'Rendez-vous annulé avec succès']);
    }


    public function createAppointment(Request $request)
    {
        $user = auth()->user();
        if ($user->role === 'doctor') {
            $doctor = $user;
        } elseif ($user->role === 'assistant') {
            $doctor = $user->doctor;
        }
        $doctor_id = $doctor->id;
        $request->validate([
            'start_date' => 'required|date|after_or_equal:now',
        ]);

        $doctorInfo = DoctorInfo::where('doctor_id', $doctor_id)->first();
        $consultationDuration = $request->consultation_duration;
        $defaultDuration = $doctorInfo->consultation_duration;
        $start = Carbon::parse($request->start_date);
        $appointment = Appointment::create([
            'doctor_id' => $doctor_id,
            'patient_id' => $request->patient_id,
            'start_date' => $request->start_date,
            'finish_date' => $consultationDuration ? $start->copy()->addMinutes($consultationDuration) : $start->copy()->addMinutes($defaultDuration),
            'consultation_type' => $request->consultation_type,
            'status' => AppointmentStatus::CONFIRMED,
        ]);
        Mail::to($appointment->patient->email)->send(new AppointmentConfirmedMail($appointment));
        $message = 'Rendez-vous créé avec succès';
        if($user->role === 'assistant')
        {
            return back()->with(['success' => $message]);
        }
        return response()->json(['success' => true, 'message' => $message, 'event' => $appointment]);
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
        Mail::to($appointment->patient->email)->send(new AppointmentUpdatedMail($appointment));
        return response()->json(['success' => true, 'message' => 'Rendez-vous déplacé avec succès']);
    }

    public function updateAppointment(Request $request, $id): JsonResponse
    {
        $appointment = $this->appointmentService->update($request, $id);
        return response()->json(['success' => true, 'message' => 'Rendez-vous mis à jour avec succès']);

    }
}
