<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Patient;
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
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // Validate the input
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'address' => ['required', 'string', 'max:255'],
            'contact_person' => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/u', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:255'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        // Begin a transaction
        DB::beginTransaction();

        try {
            // Create the user
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);

            // Assign the selected role to the new user
            $user->assignRole('patient');

            // Create a new Patient record and associate it with the created user
            $patient = new Patient([
                'name' => $input['name'],
                'contact' => $input['contact'],
                'email' => $input['email'],
                'address' => $input['address'],
                'contact_person' => $input['contact_person'],
                'status' => $input['status'],
                'user_id' => $user->id, // Use the ID of the created user
            ]);
            $patient->save();

            // Commit the transaction
            DB::commit();

            // Return the created user
            return $user;
        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();

            // Optionally rethrow the exception or handle it as needed
            throw $e;
        }
    }
}
