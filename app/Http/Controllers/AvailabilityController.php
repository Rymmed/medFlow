<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Models\User;
use Illuminate\Http\Request;
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
//        dd($validator['start_time']);
        $availability = Availability::where('doctor_id', $doctor_id)->firstOrFail();
        $availability->days_of_week = json_encode($validator['days_of_week']);
        $availability->start_time = $validator['start_time'];
        $availability->end_time = $validator['end_time'];
        $availability->consultation_duration = $validator['consultation_duration'];
        $availability->save();
//        dd($availability->start_time);

        return redirect()->back()->with('success', 'Horaires fixés avec succès.');
    }
}
