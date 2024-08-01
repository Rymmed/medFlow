<?php

namespace App\Models;

 use App\Enums\AppointmentStatus;
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
        'role',
        'dob',
        'phone_number',
        'gender',
        'profile_image',
        'address',
        'city',
        'country',
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
        return $this->hasMany(User::class, 'doctor_id');
    }
     public function doctorAppointments(): HasMany
     {
         return $this->hasMany(Appointment::class, 'doctor_id');
     }

     public function patientAppointments(): HasMany
     {
         return $this->hasMany(Appointment::class, 'patient_id');
     }

     public function doctor_info(): HasOne
     {
         return $this->hasOne(DoctorInfo::class, 'doctor_id');
     }

     public function medicalRecord(): HasOne
     {
         return $this->hasOne(MedicalRecord::class, 'patient_id');
     }

     public function consultationReports(): HasMany
     {
         return $this->hasMany(ConsultationReport::class, 'doctor_id');
     }

     public function isAvailable($appointmentStartTime): array
     {
         $dayOfWeek = Carbon::parse($appointmentStartTime)->dayOfWeek;
         $appointmentTime = Carbon::parse($appointmentStartTime)->format('H:i:s');
         $errors = [];
         $isAvailableDate = $this->doctor_info()
             ->whereRaw("JSON_CONTAINS(`days_of_week`, '\"$dayOfWeek\"')")
             ->exists();
         if (!$isAvailableDate) {
             $errors[] = "Le médecin n'est pas disponible dans ce jour!";
         }
         $isAvailableStartTime = $this->doctor_info()
             ->where('start_time', '<=', $appointmentTime)
             ->exists();

         if(!$isAvailableStartTime){
             $errors[] = "Le cabinet s'ouvre après l'heure choisie!";
         }

         $isAvailableEndTime = $this->doctor_info()
             ->where('end_time', '>=', $appointmentTime)
             ->exists();
         if(!$isAvailableEndTime) {
             $errors[] = "Le cabinet se ferme avant cette heure!";
         }
         $isAvailable = $isAvailableDate && $isAvailableStartTime && $isAvailableEndTime;

         if (!$isAvailable) {
             return ['isAvailable' => false, 'errors' => $errors];
         }
         $appointmentExists = $this->doctorAppointments()
             ->where('status', AppointmentStatus::CONFIRMED)
             ->where(function ($query) use ($appointmentStartTime) {
                 $query->where('start_date', '<=', $appointmentStartTime)
                     ->where('finish_date', '>=', $appointmentStartTime);
             })
             ->exists();

         if ($appointmentExists) {
             $errors[] = "Il y a une consultation à ce moment. Veuillez choisir une autre heure";
             return ['isAvailable' => false, 'errors' => $errors];
         }

         if (!empty($errors)) {
             return ['isAvailable' => false, 'errors' => $errors];
         }
         return ['isAvailable' => true, 'errors' => []];
     }
 }
