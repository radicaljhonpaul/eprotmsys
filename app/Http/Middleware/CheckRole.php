<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class CheckRole 
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  String  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {

        if(Auth::check()){
            if($role == 'admin'){
                if(auth()->user()->user_role == 'admin'){
                    // dd("admin");
                    return $next($request);
                }else{
                    return Redirect::route('office.dashboard.index');
                    dd("redirect to office");
                }
            }else{
                if(auth()->user()->user_role == 'office'){
                    // dd("office");
                    return $next($request);
                }else{
                    return Redirect::route('admin.dashboard.index');
                    dd("redirect to admin");
                }
            }
            
            // return Redirect::route($role.'.dashboard.index');

        }else{
            // Redirect to login
            return Redirect::route('login');
        }
    }
}
