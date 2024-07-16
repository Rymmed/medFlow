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
use Illuminate\View\View;

class DoctorInfoController extends Controller
{

    public function update(Request $request, $doctor_id)
    {
        $validator = $request->validate([
            'doctor_id' => $doctor_id,
            'days_of_week' => 'required|array',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'office_phonne_number' => 'string',
        ]);

        $doctor_info = DoctorInfo::where('doctor_id', $doctor_id)->firstOrFail();
        $doctor_info->speciality = $request->speciality;
        $doctor_info->days_of_week = json_encode($validator['days_of_week']);
        $doctor_info->start_time = $validator['start_time'];
        $doctor_info->end_time = $validator['end_time'];
        $doctor_info->office_phone_number = $validator['office_phone_number'];

        $consultation_infos = ConsultationInfo::where('doctor_info_id', $doctor_info->id)->get();
        foreach ($consultation_infos as $consultation_info){
            $request->validate([
                'type' => 'required|in:' . implode(',', ConsultationType::getValues()),
                'fees' => 'required|string',
                'duration' => 'required|numeric|min:1',
            ]);
            $consultation_info->type = $request->type;
            $consultation_info->fees = $request->fees;
            $consultation_info->duration = $request->duration;
            $consultation_info->save();

        }
        $doctor_info->save();
        $appointments = Appointment::where('doctor_id', $doctor_id)->get();
        foreach ($appointments as $appointment){
            $start = Carbon::parse($appointment->start_date);
            $appointment->finish_date = $start->copy()->addMinutes($doctor_info->consultation_duration);
            $appointment->save();
        }

        return redirect()->back()->with('success', 'Horaires fixés avec succès.');
    }
}
