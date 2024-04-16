<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $user_role=Auth::user()->role;
        switch($user_role) {
            case ("super-admin"):
                return view('super-admin.home');
                break;
            case "admin":
                return view('admin.home');
                break;
            case "doctor":
                return view('doctor.home');
                break;
            case "patient":
                return view('patient.home');
                break;
            case "assistant":
                return view('assistant.home');
                break;
            default:
                Auth::logout();
                return view('/login')->with('error', 'oops something went wrong');
        }
    }
}
