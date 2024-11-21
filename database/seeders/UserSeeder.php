<?php
// UserSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create an admin user
        $admin = User::create([
            'name' => 'Thabit H kasomo',
            'email' => 'admin@doctorapp.com',
            'password' => bcrypt('nit@2024'),
        ]);
        $admin->assignRole('super_admin');

        // Create a doctor user
        $doctorUser = User::create([
            'name' => 'Michael K Zuberi',
            'email' => 'doctor@doctorapp.com',
            'password' => bcrypt('nit@2024'),
            
        ]);
        $doctorUser->assignRole('doctor');

        // Create a doctor record
        Doctor::create([
            'name' => 'Michael K Zuberi',
            'contact' => '+255-756-787-890',
            'email' => 'doctor@doctorapp.com',
            'address' => 'Dar es salaam',
            'qualification' => 'Masters In Doctor of Medicine',
            'specialty' => 'Cardiac Specialist',
            'status' => 'active',
        ]);

        // Create a patient user
        $patientUser = User::create([
            'name' => 'Najim Z Ahmad',
            'email' => 'patient@doctorapp.com',
            'password' => bcrypt('nit@2024'),
        ]);
        $patientUser->assignRole('patient');

        // Create a patient record
        Patient::create([
            'name' => 'Najim Z Ahmad',
            'contact' => '+255-787-654 676',
            'email' => 'patient@doctorapp.com',
            'address' => 'Dar es salaam',
            'contact_person' => 'Contact Person',
            'status' => 'active',
        ]);

        // Add more users and assign roles as needed
    }
}
