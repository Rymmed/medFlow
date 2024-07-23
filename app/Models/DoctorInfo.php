<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DoctorInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'speciality',
        'professional_card',
        'days_of_week',
        'start_time',
        'end_time',
        'office_phone_number',
        'consultation_duration',
        'consultation_types',
        'online_fees',
        'home_service_fees',
        'in_person_fees',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }

//    public function consultation_info(): HasMany
//    {
//        return $this->hasMany(ConsultationInfo::class, 'doctor_id');
//    }

    public function formattedDays()
    {
        $daysOfWeek = ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'];
        $days = json_decode($this->days_of_week);
        return collect($days)->map(function ($day) use ($daysOfWeek) {
            return $daysOfWeek[$day];
        })->implode('-');
    }

    public function formattedTime()
    {
        $startTime = date('H:i', strtotime($this->start_time));
        $endTime = date('H:i', strtotime($this->end_time));
        return 'De '. $startTime . ' jusqu\'à '. $endTime;
    }
}
