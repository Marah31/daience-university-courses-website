<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
    //...$this->profileRules(),
    'name' => ['required', 'string', 'max:255'],
    'email' => ['nullable', 'email', 'max:255', 'unique:users,email'],
    'phone' => ['nullable', 'string', 'max:20', 'unique:users,phone'],
    'password' => $this->passwordRules(),
    ])->after(function ($validator) use ($input) {
        if (empty($input['email']) && empty($input['phone'])) {
            $validator->errors()->add('email', 'You must provide either an email or a phone number.');
        }
    })->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'] ?? null,
            'phone' => $input['phone'] ?? null,
            'password' => Hash::make($input['password']),
        ]);
    }
}
