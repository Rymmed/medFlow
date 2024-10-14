<?php

namespace App\Http\Controllers;

use App\Mail\NewUserWelcome;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AssistantDoctorController extends Controller
{
    public function index()
    {
        $doctor = auth()->user();
        $assistants = $doctor->assistants;
        return view('doctor.assistants.index', compact('assistants'));
    }

    public function create()
    {
        return view('doctor.assistants.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lastName' => 'required|string',
            'firstName' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $assistant = new User;
        $assistant->lastName = $request->lastName;
        $assistant->firstName = $request->firstName;
        $assistant->email = $request->email;
        $assistant->password = Hash::make($request->password);
        $assistant->gender = $request->gender;
        $assistant->role = 'assistant';
        $assistant->doctor_id = auth()->user()->id;
        $assistant->save();
        Mail::to($assistant->email)->send(new NewUserWelcome($assistant));

        return redirect()->route('doctor-assistants.index')->with('success', 'Assistant ajouté avec succès.');
    }

    public function show($id)
    {
        $assistant = User::findOrFail($id);
        return view('doctor.assistants.show', compact('assistant'));
    }

    public function edit($id)
    {
        $assistant = User::findOrFail($id);
        return view('doctor.assistants.edit', compact('assistant'));
    }

    public function update(Request $request, $id)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'lastName' => 'required|string',
            'firstName' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$id,
            'gender' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Mise à jour des données de l'utilisateur
        $assistant = User::findOrFail($id);
        $assistant->lastName = $request->lastName;
        $assistant->firstName = $request->firstName;
        $assistant->email = $request->email;

        $assistant->save();

        return redirect()->back()->with('success', 'Profil assistant mis à jour avec succès.');
    }

    public function activate($id)
    {
        $assistant = User::findOrFail($id);
        $assistant->update(['status' => true]);
        return redirect()->route('doctor-assistants.index')->with('success', 'Le compte du assistant a été activé avec succès.');
    }
    public function deactivate($id)
    {
        $assistant = User::findOrFail($id);
        $assistant->update(['status' => false]);
        return redirect()->route('doctor-assistants.index')->with('success', 'Le compte du assistant a été désactivé avec succès.');
    }
    public function destroy($id)
    {
        $assistant = User::findOrFail($id);
        $assistant->delete();
        return redirect()->route('doctor-assistants.index')->with('success', 'assistant supprimé avec succès.');
    }
}
