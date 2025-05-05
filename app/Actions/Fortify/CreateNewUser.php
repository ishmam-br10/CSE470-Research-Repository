<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Researcher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Validation\Rule;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                function ($attribute, $value, $fail) {
                    $domain = substr(strrchr($value, "@"), 1);
                    $allowedDomains = ['g.bracu.ac.bd', 'bracu.ac.bd'];
                    
                    if (!in_array($domain, $allowedDomains)) {
                        $fail('The email must use a BRAC University domain (@g.bracu.ac.bd or @bracu.ac.bd).');
                    }
                },
            ],
            'role' => ['required', 'string', 'in:researcher,non-researcher'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'role' => $input['role'],
            'password' => Hash::make($input['password']),
        ]);

        // If the user is a researcher, create a researcher profile
        if ($input['role'] === 'researcher') {
            Researcher::create([
                'name' => $input['name'],
                'user_id' => $user->id,
                // Default values
                'department' => 'Not specified',
                'contact' => 'Not specified'
            ]);
        }

        return $user;
    }
}