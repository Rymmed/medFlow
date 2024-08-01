<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vaccination;
use Illuminate\Auth\Access\Response;

class VaccinationPolicy
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
    public function view(User $user, Vaccination $vaccination): bool
    {
        $patient_id = $vaccination->medicalRecord->patient_id;
        return $user->id === $patient_id || $user->patients()->where('patient_id', $patient_id)->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, $patient): bool
    {
        return $user->id === $patient->id || $user->patients()->where('patient_id', $patient->id)->exists();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Vaccination $vaccination): bool
    {
        $patient_id = $vaccination->medicalRecord->patient_id;
        return $user->id === $patient_id || $user->patients()->where('patient_id', $patient_id)->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Vaccination $vaccination): bool
    {
        $patient_id = $vaccination->medicalRecord->patient_id;
        return $user->id === $patient_id || $user->patients()->where('patient_id', $patient_id)->exists();
    }

}
