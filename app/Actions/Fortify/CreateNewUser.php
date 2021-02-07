<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

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
        Validator::make($input, [
            'firstname' => ['required', 'min:2', 'max:20', 'regex:/^[A-Za-z]+$/'],
            'lastname' => ['required', 'min:2', 'max:30', 'regex:/^[A-Za-z]+$/'],
            'username' => ['required', 'min:2', 'max:20', 'unique:users', 'regex:/^[a-zA-Z][a-zA-Z0-9_-]+$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();
        
        return User::create([
            'firstname' => ucfirst(strtolower($input['firstname'])),
            'lastname' => ucfirst(strtolower($input['lastname'])),
            'username' => $input['username'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}