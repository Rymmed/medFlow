<?php

namespace App\Http\Controllers\Auth;

use App\Enums\BloodGroup;
use App\Enums\ConsultationType;
use App\Enums\PatientArea;
use App\Enums\VitalSignsType;
use App\Http\Controllers\Controller;
use App\Mail\NewUserWelcome;
use App\Models\Availability;
use App\Models\DoctorInfo;
use App\Models\MedicalRecord;
use App\Models\User;
use App\Models\VitalSign;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'lastName' => 'required|string|max:255',
            'firstName' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|max:255',
            'dob' => 'date',
            'phone_number' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'gender' => 'required|boolean',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ];

        if (isset($data['role']) && $data['role'] === 'doctor') {
            $doctorRules = [
                'speciality' => 'required|string|max:255',
                'professional_card' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                'days_of_week' => 'required|array',
                'start_time' => 'required',
                'end_time' => 'required|after:start_time',
                'office_phone_number' => 'nullable|string|max:255',
                'consultation_duration' => 'nullable|numeric|min:1',
                'online_fees' => 'nullable|string|max:255',
                'home_service_fees' => 'nullable|string|max:255',
                'in_person_fees' => 'nullable|string|max:255',
                'consultation_types' => 'required|array',
                'consultation_types.*' => ['required', Rule::in(ConsultationType::getValues())],
            ];
            $rules = array_merge($rules, $doctorRules);
        } elseif (isset($data['role']) && $data['role'] === 'patient') {
            $patientRules = [
                'height' => 'nullable|numeric',
                'weight' => 'nullable|numeric',
                'blood_group' => ['nullable', 'string', Rule::in(BloodGroup::getValues())],
                'smoking' => 'nullable|boolean',
                'alcohol' => 'nullable|boolean',
                'area' => ['nullable', 'string', Rule::in(PatientArea::getValues())],
                'sedentary_lifestyle' => 'nullable|boolean',
            ];
            $rules = array_merge($rules, $patientRules);
        }

        return Validator::make($data, $rules);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'lastName' => ucwords($data['lastName']),
            'firstName' => ucwords($data['firstName']),
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'dob' => $data['dob'],
            'gender' => $data['gender'],
            'phone_number' => $data['phone_number'],
            'address' => $data['address'] ?? null,
            'city' => $data['city'] ?? null,
            'country' => $data['country'] ?? null,
        ]);

        if (request()->hasFile('profile_image')) {
            $image = request()->file('profile_image');
            $path = $image->store('profile_images', 'public');
            $user->profile_image = $path ?? null;
            $user->save();
        }

        if ($user->role === 'patient') {
            $medicalRecord = new MedicalRecord();
            $medicalRecord->patient_id = $user->id;
            $medicalRecord->height = $data['height'] ?? null;
            $medicalRecord->weight = $data['weight'] ?? null;
            $medicalRecord->blood_group = $data['blood_type'] ?? null;
            $medicalRecord->smoking = $data['smoking'] ?? null;
            $medicalRecord->alcohol = $data['alcohol'] ?? null;
            $medicalRecord->area = $data['area'] ?? null;
            $medicalRecord->sedentary_lifestyle = $data['sedentary_lifestyle'] ?? null;
            $medicalRecord->temperature = null;
            $medicalRecord->heart_rate = null;
            $medicalRecord->blood_pressure = null;
            $medicalRecord->respiratory_rate = null;
            $medicalRecord->oxygen_saturation = null;
            $medicalRecord->save();
        }

        if ($user->role === 'doctor') {
            $doctor_info = new DoctorInfo();
            $doctor_info->doctor_id = $user->id;
            $doctor_info->speciality = $data['speciality'] ?? null;
            $doctor_info->days_of_week = json_encode($data['days_of_week']);
            $doctor_info->start_time = $data['start_time'];
            $doctor_info->end_time = $data['end_time'];
            $doctor_info->office_phone_number = $data['office_phone_number'] ?? null;
            $doctor_info->consultation_duration = $data['consultation_duration'] ?? null;
            $doctor_info->consultation_types = json_encode($data['consultation_types']);
            $doctor_info->online_fees = $data['online_fees'] ?? null;
            $doctor_info->home_service_fees = $data['home_service_fees'] ?? null;
            $doctor_info->in_person_fees = $data['in_person_fees'] ?? null;

            if (request()->hasFile('professional_card')) {
                $professionalCard = request()->file('professional_card');
                $path = $professionalCard->store('professional_cards', 'public');
                $doctor_info->professional_card = $path;
            }

            $doctor_info->save();
        }
        Mail::to($user->email)->send(new NewUserWelcome($user));
        return $user;
    }

}
