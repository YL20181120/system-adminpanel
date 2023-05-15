<?php

namespace Admin\Actions\Fortify;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Admin\Models\User;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param array<string, string> $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'username'    => ['required', 'string', 'max:255', Rule::unique(User::class)],
            'email'       => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'description' => ['nullable', 'string', 'max:255']
        ])->validate();

        return User::create([
            'username'    => $input['username'],
            'email'       => $input['email'],
            'password'    => Hash::make(uniqid()),
            'description' => $input['description'],
            'phone'       => $input['phone'],
        ]);
    }
}
