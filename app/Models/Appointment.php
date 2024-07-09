<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'start_date',
        'finish_date',
        'consultation_reason',
        'consultation_type',
        'status',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class)->where('role', 'patient');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class)->where('role', 'doctor');
    }
}
