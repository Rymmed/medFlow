<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        return view('super-admin.admins.index');
    }

    public function addAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lastName' => 'required|string',
            'firstName' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
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

        return redirect()->back()->with('success', 'Administrateur ajouté avec succès.');
    }
}
