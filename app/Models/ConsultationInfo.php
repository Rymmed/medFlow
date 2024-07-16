<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultationInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_info_id',
        'type',
        'fees',
        'duration',
    ];

    public function doctor_info(): BelongsTo
    {
        return $this->belongsTo(DoctorInfo::class, 'doctor_info_id');
    }
}
