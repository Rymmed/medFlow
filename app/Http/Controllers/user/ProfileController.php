<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\DoctorInfo;
use App\Models\User;
use Closure;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        $user = Auth::user();
        $role = $user->role;
        if ($user->role === 'doctor') {
            $doctor_info = DoctorInfo::where('doctor_id', $user->id)->first() ;
            return view('doctor.profile', compact('doctor_info'));
        }
        else {
            return view($role . '.profile');
        }
    }

    public function updateProfileImg(Request $request)
    {
        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'cropped_image' => 'nullable|string',
        ]);

        $user = auth()->user();
        if ($request->hasFile('profile_image')) {

            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
            $user->save();
        }

        return redirect()->back()->with('success', 'Image de profile modifiée avec succès.');
    }

    public function update(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required', 'email', Rule::unique('users')->ignore($user->id),
            'password' => 'nullable|min:8|confirmed',
            'phone_number' => 'required',
            'dob' => 'required|date',
            'insurance_number' => 'nullable',
            'cin_number' => 'nullable',
            'speciality' => 'nullable',
            'registration_number' => 'nullable',
        ]);

        $user->update([
            'lastName' => $request->lastName,
            'firstName' => $request->firstName,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'dob' => $request->dob,
            'insurance_number' => $request->insurance_number,
            'cin_number' => $request->cin_number,
            'speciality' => $request->speciality,
            'registration_number' => $request->registration_number
        ]);
        return redirect('myProfile')->with('success', 'Profil mis à jour avec succès');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|different:current_password|confirmed',
        ]);
        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $user->fill([
                'password' => Hash::make($request->new_password)
            ])->save();

            $request->session()->flash('success', 'Mot de passe mis à jour avec succès.');
            return redirect()->route('myProfile');

        } else {
            $request->session()->flash('error', 'Le mot de passe actuel est incorrect.');
            return redirect()->route('myProfile');
        }

    }

}
