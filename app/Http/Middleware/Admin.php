<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class Admin
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
        if($user->role==2){
            return $next($request);
        }

        if($user->role==1){
            return redirect('/Superadmin');
        }

        if($user->role==3){
            return redirect('/doctor');
        }

        if($user->role==4){
            return redirect('/patient');
        }

        if($user->role==5){
            return redirect('/assistant');
        }
    }
}
