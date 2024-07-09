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
        'profile_image',
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
        return $this->belongsTo(User::class, 'doctor_id');
    }

     public function doctors(): BelongsToMany
     {
         return $this->belongsToMany(User::class, 'doctor_patient', 'patient_id', 'doctor_id');
     }

     public function patients(): BelongsToMany
     {
         return $this->belongsToMany(User::class, 'doctor_patient', 'doctor_id', 'patient_id');
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

    public function isAvailable($appointmentStartTime): array
    {
        $dayOfWeek = Carbon::parse($appointmentStartTime)->dayOfWeek;
        $appointmentTime = Carbon::parse($appointmentStartTime)->format('H:i:s');
        $errors = [];
        $isAvailableDate = $this->availability()
            ->whereRaw("JSON_CONTAINS(`days_of_week`, '\"$dayOfWeek\"')")
            ->exists();
        if (!$isAvailableDate) {
            $errors[] = "Le médecin n'est pas disponible dans ce jour!";
        }
        $isAvailableStartTime = $this->availability()
            ->where('start_time', '<=', $appointmentTime)
            ->exists();

        if(!$isAvailableStartTime){
            $errors[] = "Le cabinet s'ouvre après l'heure choisie!";
        }

        $isAvailableEndTime = $this->availability()
            ->where('end_time', '>=', $appointmentTime)
            ->exists();
        if(!$isAvailableEndTime) {
            $errors[] = "Le cabinet se ferme avant cette heure!";
        }
        $isAvailable = $isAvailableDate && $isAvailableStartTime && $isAvailableEndTime;

        if (!$isAvailable) {
            return ['isAvailable' => false, 'errors' => $errors];
        }

        $availability = $this->availability()->where('doctor_id', $this->id)->first();
        $end_time= $availability->end_time;
        $appointmentExists= $this->doctorAppointments()
            ->where('start_time', $appointmentTime)
            ->where('finish_time', $end_time)
            ->where('status', 'confirmed')
            ->exists();

        if ($appointmentExists) {
            $errors[] = "Le médecin a un rendez-vous confirmé.";
            return ['isAvailable' => false, 'errors' => $errors];
        }

        return ['isAvailable' => true, 'errors' => []];
    }

     public function consultationReportsAsPatient(): HasMany
     {
         return $this->hasMany(ConsultationReport::class, 'patient_id');
     }

     public function consultationReportsAsDoctor(): HasMany
     {
         return $this->hasMany(ConsultationReport::class, 'doctor_id');
     }
     public function allergies(): HasMany
     {
         return $this->hasMany(Allergy::class);
     }

     public function medicalHistories(): HasMany
     {
         return $this->hasMany(MedicalHistory::class);
     }

     public function vaccinations(): HasMany
     {
         return $this->hasMany(Vaccination::class);
     }

     public function examResults(): HasMany
     {
         return $this->hasMany(ConsultationReport::class);
     }
}
