<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Assistant
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check()){
            return redirect('/login');
        }

        $user = Auth::user();
        if($user->role=="assistant"){
            return $next($request);
        }

        if($user->role=="admin"){
            return redirect('/admin');
        }

        if($user->role=="doctor"){
            return redirect('/doctor');
        }

        if($user->role=="patient"){
            return redirect('/patient');
        }

        if($user->role=="super-admin"){
            return redirect('/super-admin');
        }
        return redirect('/login');
    }
}
