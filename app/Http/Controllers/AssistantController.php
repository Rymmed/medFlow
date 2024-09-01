<?php

namespace App\Http\Controllers;

use App\Mail\NewUserWelcome;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AssistantController extends Controller
{
    public function index()
    {
        $assistants = User::where('role', 'assistant')->get();
        return view('super-admin.assistants.index', compact('assistants'));
    }

    public function create()
    {
        $doctors = User::where('role', 'doctor')->get();
        return view('super-admin.assistants.create', compact('doctors'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lastName' => 'required|string',
            'firstName' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'required|boolean',
            'phone_number' => 'nullable|string|max:255',
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
        $assistant->phone_number = $request->phone_number;
        $assistant->role = 'assistant';
        $assistant->doctor_id = $request->input('doctor_id');
        $assistant->save();
        Mail::to($assistant->email)->send(new NewUserWelcome($assistant));
        return redirect()->back()->with('success', 'Assistant ajouté avec succès.');
    }

    public function show($id)
    {
        $assistant = User::findOrFail($id);
        return view('super-admin.assistants.show', compact('assistant'));
    }

    public function edit($id)
    {
        $assistant = User::findOrFail($id);
        $doctors = User::where('role', 'doctor')->get();
        return view('super-admin.assistants.edit', compact(['assistant', 'doctors']));
    }

    public function update(Request $request, $id)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'lastName' => 'required|string',
            'firstName' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$id,
            'gender' => 'required|boolean',
            'phone_number' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Mise à jour des données de l'utilisateur
        $assistant = User::findOrFail($id);
        $assistant->lastName = $request->lastName;
        $assistant->firstName = $request->firstName;
        $assistant->email = $request->email;
        $assistant->gender = $request->gender;
        $assistant->phone_number = $request->phone_number;
        $assistant->doctor_id = $request->input('doctor_id');

        $assistant->save();

        return redirect()->back()->with('success', 'Profil assistant mis à jour avec succès.');
    }

    public function activate($id)
    {
        $assistant = User::findOrFail($id);
        $assistant->update(['status' => true]);
        return redirect()->route('assistants.index')->with('success', 'Le compte du assistant a été activé avec succès.');
    }
    public function deactivate($id)
    {
        $assistant = User::findOrFail($id);
        $assistant->update(['status' => false]);
        return redirect()->route('assistants.index')->with('success', 'Le compte du assistant a été désactivé avec succès.');
    }
    public function destroy($id)
    {
        $assistant = User::findOrFail($id);
        $assistant->delete();
        return redirect()->route('assistants.index')->with('success', 'assistant supprimé avec succès.');
    }
}
