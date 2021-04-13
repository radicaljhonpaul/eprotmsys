<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
	
	public function toResponse($request){

		if(Auth::user()->user_role == 'office'){
			return redirect()->route('office.dashboard.index');
		}elseif(Auth::user()->user_role == 'admin'){
			return redirect()->route('admin.dashboard.index');
		}
	}
}
