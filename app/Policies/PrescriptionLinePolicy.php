<?php

namespace App\Policies;

use App\Models\Prescription;
use App\Models\PrescriptionLine;
use App\Models\User;
use Illuminate\Auth\Access\Response;


class PrescriptionLinePolicy
{

    public function viewAny(User $user, $patient): bool
    {
        return $user->id === $patient->id || $user->patients()->where('patient_id', $patient->id)->exists();
    }

    public function view(User $user, PrescriptionLine $line)
    {
        $prescription = $line->prescription;
        return $user->id === $prescription->consultationReport->doctor_id || $user->id === $prescription->consultationReport->appointment->patient_id;
    }

    public function create(User $user, $prescription_id)
    {
        $prescription = Prescription::findOrFail($prescription_id);
        return $user->id === $prescription->consultationReport->doctor_id;
    }

    public function update(User $user, PrescriptionLine $line)
    {
        return $user->id === $line->prescription->consultationReport->doctor_id;
    }

    public function delete(User $user, PrescriptionLine $line)
    {
        return $user->id === $line->prescription->consultationReport->doctor_id;
    }

}
