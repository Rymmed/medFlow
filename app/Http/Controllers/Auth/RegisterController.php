<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\DoctorInfo;
use App\Models\MedicalRecord;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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
    protected $redirectTo = '/home';

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
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'lastName' => 'required|string|max:255',
            'firstName' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|max:255',
            'dob' => 'required|date',
            'phone_number' => 'required|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'gender' => 'required|boolean',
            'address' => 'string|max:255',
            'city' => 'string|max:255',
            'country' => 'string|max:255',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
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
            'address' => $data['address'],
            'city' => $data['city'],
            'country' => $data['country'],
        ]);
        if (request()->hasFile('profile_image')) {
            $image = request()->file('profile_image');
            $path = $image->store('profile_images', 'public');
            $user->profile_image = $path;
            $user->save();
        }

        if ($user->role === 'patient') {
            $medicalRecord = new MedicalRecord();
            $medicalRecord->patient_id = $user->id;
            $medicalRecord->save();
        }

        if ($user->role === 'doctor'){
            $doctor_info = new DoctorInfo();
            $doctor_info->doctor_id = $user->id ;
            $doctor_info->save();
        }
        return $user ;

    }
}
