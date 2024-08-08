<?php

namespace App\Http\Controllers;

use App\Enums\ConsultationType;
use App\Models\Appointment;
use App\Models\ConsultationInfo;
use App\Models\DoctorInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DoctorInfoController extends Controller
{

    public function update(Request $request, $doctor_id)
    {
        $validator = $request->validate([
            'days_of_week' => 'required|array',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'office_phone_number' => 'nullable|string',
            'consultation_duration' => 'nullable|numeric|min:1',
            'online_fees' => 'nullable|string',
            'home_service_fees' => 'nullable|string',
            'in_person_fees' => 'nullable|string',
            'consultation_types' => 'required|array',
            'consultation_types.*' => ['required', Rule::in(ConsultationType::getValues())],
        ]);

        $doctor_info = DoctorInfo::where('doctor_id', $doctor_id)->firstOrFail();
        $doctor_info->speciality = $request->speciality;
        $doctor_info->days_of_week = json_encode($validator['days_of_week']);
        $doctor_info->start_time = $validator['start_time'];
        $doctor_info->end_time = $validator['end_time'];
        $doctor_info->office_phone_number = $validator['office_phone_number'];
        $doctor_info->consultation_duration = $validator['consultation_duration'];
        $doctor_info->online_fees = $validator['online_fees'];
        $doctor_info->home_service_fees = $validator['home_service_fees'];
        $doctor_info->in_person_fees = $validator['in_person_fees'];
        $doctor_info->consultation_types = json_encode($validator['consultation_types']);
        $doctor_info->save();

        $appointments = Appointment::where('doctor_id', $doctor_id)->get();
        foreach ($appointments as $appointment) {
            $start = Carbon::parse($appointment->start_date);
            $appointment->finish_date = $start->copy()->addMinutes($doctor_info->consultation_duration);
            $appointment->save();
        }

        return redirect()->back()->with('success', 'Horaires fixés avec succès.');
    }
}
