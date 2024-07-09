<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Availability;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AvailabilityController extends Controller
{

    public function update(Request $request, $doctor_id)
    {
        $validator = $request->validate([
            'doctor_id' => $doctor_id,
            'days_of_week' => 'required|array',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'consultation_duration' => 'required|numeric|min:1',
        ]);

        $availability = Availability::where('doctor_id', $doctor_id)->firstOrFail();
        $availability->days_of_week = json_encode($validator['days_of_week']);
        $availability->start_time = $validator['start_time'];
        $availability->end_time = $validator['end_time'];
        $availability->consultation_duration = $validator['consultation_duration'];
        $availability->save();
        $appointments = Appointment::where('doctor_id', $doctor_id)->get();
        foreach ($appointments as $appointment){
            $start = Carbon::parse($appointment->start_time);
            $appointment->finish_time = $start->copy()->addMinutes($availability->consultation_duration);
            $appointment->save();
        }

        return redirect()->back()->with('success', 'Horaires fixés avec succès.');
    }
}
