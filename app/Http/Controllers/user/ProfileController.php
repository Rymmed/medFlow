<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('user.profile');
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = auth()->user();

        $user->update([
           'lastName' => $request->lastName,
           'firstName' => $request->firstName,
            'email' => $request->email,
//            'password' => $request->password,
            'phone_number' => $request->phone_number,
            'dob' => $request->dob,
            'insurance_number' => $request->insurance_number,
            'cin_number' => $request->cin_number,
            'speciality' => $request->speciality,
            'registration_number' => $request->registration_number
        ]);
        return redirect('user/profile')->with('success', 'Profile Updated');
    }
}
