<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'height',
        'weight',
        'blood_group',
        'smoking',
        'alcohol',
        'area',
        'sedentary_lifestyle',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function medicalHistories(): HasMany
    {
        return $this->hasMany(MedicalHistory::class, 'medicalRecord_id');
    }

    public function vaccinations(): HasMany
    {
        return $this->hasMany(Vaccination::class, 'medicalRecord_id');
    }

    public function examResults(): HasMany
    {
        return $this->hasMany(ExamResult::class, 'medicalRecord_id');
    }

    public function vitalSigns(): HasMany
    {
        return $this->hasMany(VitalSign::class, 'medicalRecord_id');
    }

    public function insurance(): HasOne
    {
        return $this->hasOne(Insurance::class, 'medicalRecord_id');
    }
}
