<?php

namespace App\Models;

 use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 use Illuminate\Database\Eloquent\Relations\BelongsTo;
 use Illuminate\Database\Eloquent\Relations\BelongsToMany;
 use Illuminate\Database\Eloquent\Relations\HasMany;
 use Illuminate\Database\Eloquent\Relations\HasOne;
 use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
 use Illuminate\Support\Carbon;
 use Laravel\Sanctum\HasApiTokens;
 use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;


 class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lastName',
        'firstName',
        'email',
        'password',
        'avatar',
        'city',
        'country',
        'role',
        'dob',
        'phone_number',
        'gender',
        'insurance_number',
        'cin_number',
        'speciality',
        'registration_number',
        'status',
        'doctor_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id')->where('role', 'doctor');
    }

    public function patients(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'doctor_patient', 'doctor_id', 'patient_id')->where('role', 'patient');
    }
    public function assistants(): HasMany
    {
        return $this->hasMany(User::class, 'doctor_id')->where('role', 'doctor');
    }
     public function doctorAppointments(): HasMany
     {
         return $this->hasMany(Appointment::class, 'doctor_id');
     }

     public function patientAppointments(): HasMany
     {
         return $this->hasMany(Appointment::class, 'patient_id');
     }

     public function availability(): HasOne
     {
         return $this->hasOne(Availability::class, 'doctor_id');
     }

    public function isAvailable($appointmentDate, $appointmentTime): bool
    {
        $dayOfWeek = Carbon::parse($appointmentDate)->dayOfWeek;

        $isAvailable = $this->availability()
            ->whereRaw("JSON_CONTAINS(`days_of_week`, '\"$dayOfWeek\"')")
            ->where('start_time', '<=', $appointmentTime)
            ->where('end_time', '>=', $appointmentTime)
            ->exists();

        $appointmentExists= $this->doctorAppointments()
            ->where('date', $appointmentDate)
            ->where('time', $appointmentTime)
            ->where('status', 'confirmed')
            ->exists();

        if (!$isAvailable) {
            return false;
        }

        return !$appointmentExists;
    }
}
