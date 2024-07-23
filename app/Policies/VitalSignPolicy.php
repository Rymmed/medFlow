<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VitalSign;
use Illuminate\Auth\Access\Response;

class VitalSignPolicy
{
    /**
     * Determine if the user can view any vital signs.
     */
    public function viewAny(User $user, $patient_id)
    {
        return $user->id === $patient_id || $user->patients()->where('patient_id', $patient_id)->exists();
    }

    /**
     * Determine if the user can view a specific vital sign.
     */
    public function view(User $user, VitalSign $vitalSign)
    {
        $patient = $vitalSign->medicalRecord->patient;
        return $user->id === $patient->id || $user->patients()->where('patient_id', $patient->id)->exists();
    }

    /**
     * Determine if the user can create a vital sign.
     */
    public function create(User $user, $patient_id)
    {
        return $user->id === $patient_id || $user->patients()->where('patient_id', $patient_id)->exists();
    }

    /**
     * Determine if the user can update a vital sign.
     */
    public function update(User $user, VitalSign $vitalSign)
    {
        $patient = $vitalSign->medicalRecord->patient;
        return $user->id === $patient->id || $user->patients()->where('patient_id', $patient->id)->exists();
    }

    /**
     * Determine if the user can delete a vital sign.
     */
    public function delete(User $user, VitalSign $vitalSign)
    {
        $patient = $vitalSign->medicalRecord->patient;
        return $user->id === $patient->id || $user->patients()->where('patient_id', $patient->id)->exists();
    }
}
