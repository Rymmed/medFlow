<?php

namespace App\Http\Controllers;

use App\Mail\NewUserWelcome;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = User::where('role', 'doctor')->get();
        return view('super-admin.doctors.index', compact('doctors'));
    }

    public function create()
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
        Mail::to($doctor->email)->send(new NewUserWelcome($doctor));
        return redirect()->back()->with('success', 'Médecin ajouté avec succès.');
    }

    public function show($id)
    {
        $doctor = User::findOrFail($id);
        return view('super-admin.doctors.show', compact('doctor'));
    }

    public function edit($id)
    {
        $doctor = User::findOrFail($id);
        return view('super-admin.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, $id)
    {
        // Validation des données
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

    public function activate($id)
    {
        $doctor = User::findOrFail($id);
        $doctor->update(['status' => true]);
        return redirect()->route('doctors.index')->with('success', 'Le compte du médecin a été activé avec succès.');
    }
    public function deactivate($id)
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
}
