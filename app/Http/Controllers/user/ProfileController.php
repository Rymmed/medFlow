<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\ConsultationReport;
use App\Models\DoctorInfo;
use App\Models\User;
use App\Services\PatientProfileService;
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
    protected PatientProfileService $patientProfileService;

    public function __construct(PatientProfileService $patientProfileService)
    {
        $this->patientProfileService = $patientProfileService;
    }
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;
        if ($user->role === 'doctor') {
            $doctor_info = DoctorInfo::where('doctor_id', $user->id)->first() ;
            return view('doctor.profile', compact('doctor_info'));
        }
        elseif($user->role === 'patient') {
            $profileData = $this->patientProfileService->getProfileData($user->id);
            return view('patient.profile', $profileData);
        }
        else {
            return view('user.profile');
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
            'email' => 'required|email', Rule::unique('users')->ignore($user->id),
            'phone_number' => 'required',
            'dob' => 'required|date',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'country' => 'nullable|string',
        ]);

        $user->update([
            'lastName' => $request->lastName,
            'firstName' => $request->firstName,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'dob' => $request->dob,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country
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
