<?php

namespace App\Services;

use App\Enums\AppointmentStatus;
use App\Mail\AppointmentUpdatedMail;
use App\Models\Appointment;
use App\Models\User;
use App\Models\ConsultationReport;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class AppointmentService
{
    public function update($request, $id)
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
        Mail::to($appointment->patient->email)->send(new AppointmentUpdatedMail($appointment));

        return compact('appointment');
    }

    public function paginate(Collection $items, $perPage = 10, $pageName = 'page')
    {
        $page = request()->input($pageName, 1);
        $total = $items->count();

        $results = $items->slice(($page - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator($results, $total, $perPage, $page, [
            'path' => request()->url(),
            'query' => request()->query(),
            'pageName' => $pageName,
        ]);
    }
}
