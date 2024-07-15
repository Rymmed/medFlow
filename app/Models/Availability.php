<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'days_of_week',
        'start_time',
        'end_time',
        'consultation_duration'
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }

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
