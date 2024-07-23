<?php

namespace App\Policies;

use App\Models\ConsultationReport;
use App\Models\User;

class ConsultationReportPolicy
{
    /**
     * Determine if the user can view any consultation reports.
     */
    public function viewAny(User $user, $patient): bool
    {
        return $user->id === $patient->id || $user->patients()->where('patient_id', $patient->id)->exists();
    }

    /**
     * Determine if the user can view a specific consultation report.
     */
    public function view(User $user, ConsultationReport $report)
    {
        $patient_id = $report->appointment->patient_id;
        return $user->id === $patient_id || $user->patients()->where('patient_id', $patient_id)->exists();
    }

    /**
     * Determine if the user can create a consultation report.
     */
    public function create(User $user, $patient_id)
    {
        return $user->patients()->where('patient_id', $patient_id)->exists();
    }

    /**
     * Determine if the user can update a consultation report.
     */
    public function update(User $user, ConsultationReport $report)
    {
        return $user->id = $report->doctor_id;
    }

    /**
     * Determine if the user can delete a consultation report.
     */
    public function delete(User $user, ConsultationReport $report)
    {
        return $user->id = $report->doctor_id;
    }

}
