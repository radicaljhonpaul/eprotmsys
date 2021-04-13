<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

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

        if($role == 'office' && auth()->user()->user_role == 'office'){
            return $next($request);
        }elseif($role == 'admin' && auth()->user()->user_role == 'admin'){
            return $next($request);
        }else{
            abort(code:403);
        }

    }
}
