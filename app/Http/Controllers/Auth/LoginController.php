<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

//    public function login(Request $request)
//    {
//        $credentials = $request->validate([
//            'email' => 'required | email',
//            'password' => 'required',
//        ]);
//
//        if(Auth::attempt($credentials)){
//            $user_role=Auth::user()->role;
//            switch($user_role){
//                case 1:
//                    return redirect('/superadmin');
//                    break;
//                case 2:
//                    return redirect('/admin');
//                    break;
//                case 3:
//                    return redirect('/doctor');
//                    break;
//                case 4:
//                    return redirect('/patient');
//                    break;
//                case 5:
//                    return redirect('/assistant');
//                    break;
//                default:
//                   Auth::logout();
//                   return redirect('/login')->with('error','oops something went wrong');
//
//            }
//
//        }else{
//            return redirect('login')->with('error','The credentials do not match our records');
//        }
//
//    }
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->route('login');
    }
}
