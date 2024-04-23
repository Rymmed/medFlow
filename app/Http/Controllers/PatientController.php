<?php

namespace App\Http\Controllers;

use App\Mail\NewUserWelcome;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    public function index()
    {
        $patients = User::where('role', 'patient')->get();
        return view('super-admin.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('super-admin.patients.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lastName' => 'required|string',
            'firstName' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $patient = new User;
        $patient->lastName = $request->lastName;
        $patient->firstName = $request->firstName;
        $patient->email = $request->email;
        $patient->password = Hash::make($request->password);
        $patient->role = 'patient';
        $patient->save();
        Mail::to($patient->email)->send(new NewUserWelcome($patient));
        return redirect()->back()->with('success', 'Patient ajouté avec succès.');
    }

    public function show($id)
    {
        $patient = User::findOrFail($id);
        return view('super-admin.patients.show', compact('patient'));
    }

    public function edit($id)
    {
        $patient = User::findOrFail($id);
        return view('super-admin.patients.edit', compact('patient'));
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
        $patient = User::findOrFail($id);
        $patient->lastName = $request->lastName;
        $patient->firstName = $request->firstName;
        $patient->email = $request->email;

        $patient->save();

        return redirect()->back()->with('success', 'Profil patient mis à jour avec succès.');
    }

    public function activate($id)
    {
        $patient = User::findOrFail($id);
        $patient->update(['status' => true]);
        return redirect()->route('patients.index')->with('success', 'Le compte du patient a été activé avec succès.');
    }
    public function deactivate($id)
    {
        $patient = User::findOrFail($id);
        $patient->update(['status' => false]);
        return redirect()->route('patients.index')->with('success', 'Le compte du patient a été désactivé avec succès.');
    }
    public function destroy($id)
    {
        $patient = User::findOrFail($id);
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient supprimé avec succès.');
    }
}
