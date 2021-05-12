<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\UsersDetails;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\DB;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        // Validator::make($input, [
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //     'password' => $this->passwordRules(),
        //     'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        // ])->validate();

        // return User::create([
        //     'name' => $input['name'],
        //     'email' => $input['email'],
        //     'password' => Hash::make($input['password']),
        // ]);

        Validator::make($input, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'user_role' => ['required', 'string'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();


        $user_data = User::create([
            'email' => $input['email'],
            'user_role' => $input['user_role'],
            'password' => Hash::make($input['password']),
        ]);

        if($user_data){

            $User = User::select('id','email')->where('email',$input['email'])->get();

            $UserDetails = new UsersDetails;
            $UserDetails->user_id_fk = $User['0']['id'];
            $UserDetails->fname = $input['fname'];
            $UserDetails->mname = $input['mname'];
            $UserDetails->lname = $input['lname'];
            $UserDetails->gender = $input['gender'];
            $UserDetails->contact = $input['contact'];
            $UserDetails->office = $input['office'];
            $UserDetails->cluster = $input['cluster'];
            $UserDetails->division = $input['division'];
            $UserDetails->position = $input['position'];
            $UserDetails->save(); 
        }else;
    
        return $user_data;

    }
}
