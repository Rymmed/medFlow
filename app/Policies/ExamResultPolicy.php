<?php

namespace App\Policies;

use App\Models\ExamResult;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ExamResultPolicy
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
    public function view(User $user, ExamResult $examResult): bool
    {
        $patient_id = $examResult->medicalRecord->patient_id;
        return $user->id === $patient_id || $user->patients()->where('patient_id', $patient_id)->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, $patient_id): bool
    {

        return $user->id === $patient_id || $user->patients()->where('patient_id', $patient_id)->exists();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ExamResult $examResult): bool
    {
        $patient_id = $examResult->medicalRecord->patient_id;
        return $user->id === $patient_id || $user->patients()->where('patient_id', $patient_id)->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ExamResult $examResult): bool
    {
        $patient_id = $examResult->medicalRecord->patient_id;
        return $user->id === $patient_id || $user->patients()->where('patient_id', $patient_id)->exists();
    }

    /**
     * Determine whether the user can restore the model.
     */
//    public function restore(User $user, ExamResult $examResult): bool
//    {
//        //
//    }

    /**
     * Determine whether the user can permanently delete the model.
     */
//    public function forceDelete(User $user, ExamResult $examResult): bool
//    {
//        //
//    }

}
