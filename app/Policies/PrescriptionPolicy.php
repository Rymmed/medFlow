<?php

namespace App\Policies;

use App\Models\Prescription;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PrescriptionPolicy
{

    public function viewAny(User $user, $patient): bool
    {
        return $user->id === $patient->id || $user->patients()->where('patient_id', $patient->id)->exists();
    }

    public function view(User $user, Prescription $prescription)
    {
        $report = $prescription->consultationReport;
        return $user->id === $report->doctor_id || $user->id === $report->appointment->patient_id;
    }

    public function create(User $user, ConsultationReport $report)
    {
        return $user->id === $report->doctor_id;
    }

    public function update(User $user, Prescription $prescription)
    {
        return $user->id === $prescription->consultationReport->doctor_id;
    }

    public function delete(User $user, Prescription $prescription)
    {
        return $user->id === $prescription->consultationReport->doctor_id;
    }
}
