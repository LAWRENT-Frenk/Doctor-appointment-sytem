<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PatientSeeder extends Seeder
{
    public function run()
    {
        // Insert a patient into the 'patients' table
        DB::table('patients')->insert([
            'name' => 'John Doe',
            'contact' => '123-456-7890',
            'email' => 'john.doe@example.com',
            'address' => '123 Main St, Anytown, USA',
            'contact_person' => 'Jane Doe',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Assign the 'patient' role to the newly created patient
        $patientRole = Role::where('name', 'patient')->first();

        // Assuming you have a User model to relate patients with roles, for example:
        // Assign the role to a user (You may need to adjust based on your actual setup)
        // $user = User::where('email', 'john.doe@example.com')->first();
        // $user->assignRole($patientRole);
    }
}
