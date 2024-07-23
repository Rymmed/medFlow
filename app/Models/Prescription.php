<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'treatment',
        'description',
        'consultation_report_id',
    ];

    public function consultationReport(): BelongsTo
    {
        return $this->belongsTo(ConsultationReport::class);
    }

    public function prescriptionLines(): HasMany
    {
        return $this->hasMany(PrescriptionLine::class);
    }
}
