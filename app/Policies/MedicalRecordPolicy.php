<?php

namespace App\Policies;

use App\Models\MedicalRecord;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MedicalRecordPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, $patient): bool
    {
        return $user->id === $patient->id || $user->patients()->where('patient_id', $patient->id)->exists();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MedicalRecord $medicalRecord): bool
    {
        $patient_id = $medicalRecord->patient_id;
        return $user->id === $patient_id || $user->patients()->where('patient_id', $patient_id)->exists();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MedicalRecord $medicalRecord): bool
    {
        $patient_id = $medicalRecord->patient_id;
        return $user->id === $patient_id || $user->patients()->where('patient_id', $patient_id)->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MedicalRecord $medicalRecord): bool
    {
        $patient_id = $medicalRecord->patient_id;
        return $user->id === $patient_id || $user->patients()->where('patient_id', $patient_id)->exists();
    }
}
