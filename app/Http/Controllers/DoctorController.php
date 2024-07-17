<?php

namespace App\Http\Controllers;

use App\Mail\NewUserWelcome;
use App\Models\Availability;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function index(): View
    {
        $doctors = User::where('role', 'doctor')->get();
        return view('super-admin.doctors.index', compact('doctors'));
    }

    public function create(): View
    {
        return view('super-admin.doctors.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lastName' => 'required|string',
            'firstName' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'speciality' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $doctor = new User;
        $doctor->lastName = $request->lastName;
        $doctor->firstName = $request->firstName;
        $doctor->email = $request->email;
        $doctor->speciality = $request->speciality;
        $doctor->password = Hash::make($request->password);
        $doctor->role = 'doctor';
        $doctor->save();
        $availability = new Availability();
        $availability->doctor_id = $doctor->id ;
        $availability->save();
        Mail::to($doctor->email)->send(new NewUserWelcome($doctor));
        return redirect()->back()->with('success', 'Médecin ajouté avec succès.');
    }

    public function show($id): View
    {
        $doctor = User::findOrFail($id);
        return view('super-admin.doctors.show', compact('doctor'));
    }

    public function edit($id): View
    {
        $doctor = User::findOrFail($id);
        return view('super-admin.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'lastName' => 'required|string',
            'firstName' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Mise à jour des données de l'utilisateur
        $doctor = User::findOrFail($id);
        $doctor->lastName = $request->lastName;
        $doctor->firstName = $request->firstName;
        $doctor->email = $request->email;
        $doctor->speciality = $request->speciality;
        $doctor->save();

        return redirect()->back()->with('success', 'Profil médecin mis à jour avec succès.');
    }

    public function activate($id): RedirectResponse
    {
        $doctor = User::findOrFail($id);
        $doctor->update(['status' => true]);
        return redirect()->route('doctors.index')->with('success', 'Le compte du médecin a été activé avec succès.');
    }
    public function deactivate($id): RedirectResponse
    {
        $doctor = User::findOrFail($id);
        $doctor->update(['status' => false]);
        return redirect()->route('doctors.index')->with('success', 'Le compte du médecin a été désactivé avec succès.');
    }
    public function destroy($id)
    {
        $doctor = User::findOrFail($id);
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'Médecin supprimé avec succès.');
    }

    public function search(): View
    {
        $results = User::where('role', 'doctor');
        return view('search_doctors', compact('results'));
    }
    public function searchDoctors(Request $request)
    {
        $speciality = $request->input('speciality');
        $city = trim($request->input('city'));
        $country = trim($request->input('country'));
        $firstName = trim($request->input('firstName'));
        $lastName = trim($request->input('lastName'));

        try {
            $doctorsQuery = User::where('role', 'doctor')
                ->join('doctor_infos', 'users.id', '=', 'doctor_infos.doctor_id')
                ->when($speciality, function ($query, $speciality) {
                    if (is_array($speciality)) {
                        $query->whereIn('doctor_infos.speciality', $speciality);
                    } else {
                        $query->where('doctor_infos.speciality', $speciality);
                    }
                })
                ->when($city, fn($query) => $query->where('users.city', $city))
                ->when($country, fn($query) => $query->where('users.country', $country))
                ->when($firstName, fn($query) => $query->where('users.firstName', 'like', '%' . $firstName . '%'))
                ->when($lastName, fn($query) => $query->where('users.lastName', 'like', '%' . $lastName . '%'));

            // Clone the query to get the total results without executing the query again
            $totalResultsQuery = clone $doctorsQuery;

            // Paginate the results
            $results = $doctorsQuery->select('users.*', 'doctor_infos.speciality')->paginate(9)->appends([
                'speciality' => $speciality,
                'city' => $city,
                'country' => $country,
                'firstName' => $firstName,
                'lastName' => $lastName,
            ]);

            $totalResults = $totalResultsQuery->select('users.*', 'doctor_infos.speciality')->get();

            return view('search_doctors', [
                'results' => $results,
                'totalResults' => $totalResults,
                'speciality' => $speciality,
                'city' => $city,
                'country' => $country,
                'firstName' => $firstName,
                'lastName' => $lastName
            ]);
        } catch (\Exception $e) {
            // Handle the exception and return an error view or message
            return back()->withErrors(['error' => 'An error occurred while searching for doctors. Please try again later.']);
        }
    }

}
