<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'view appointments',
            'create appointments',
            'edit appointments',
            'delete appointments',
            'view doctors',
            'create doctors',
            'edit doctors',
            'delete doctors',
            'view pharmacy',
            'create pharmacy',
            'edit pharmacy',
            'delete pharmacy',
            'view patients',
            'create patients',
            'edit patients',
            'delete patients',
            'view reports',
            'view settings',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
