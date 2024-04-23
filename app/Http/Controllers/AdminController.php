<?php

namespace App\Http\Controllers;

use App\Mail\NewAdminWelcome;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        return view('super-admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('super-admin.admins.create');
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

        $admin = new User;
        $admin->lastName = $request->lastName;
        $admin->firstName = $request->firstName;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->role = 'admin';
        $admin->save();
        Mail::to($admin->email)->send(new NewAdminWelcome($admin));
        return redirect()->back()->with('success', 'Administrateur ajouté avec succès.');
    }

    public function show($id)
    {
        $admin = User::findOrFail($id);
        return view('super-admin.admins.show', compact('admin'));
    }

    public function edit($id)
    {
        $admin = User::findOrFail($id);
        return view('super-admin.admins.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'lastName' => 'required|string',
            'firstName' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$id,
            // Ajoutez d'autres règles de validation au besoin
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Mise à jour des données de l'utilisateur
        $user = User::findOrFail($id);
        $user->lastName = $request->lastName;
        $user->firstName = $request->firstName;
        $user->email = $request->email;

        $user->save();

        return redirect()->back()->with('success', 'Profil utilisateur mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        $admin->update(['status' => false]);
        return redirect()->route('admins.index')->with('success', 'Le compte de l\'administrateur a été désactivé avec succès.');
    }
}
