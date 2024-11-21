<?php
// RoleSeeder.php
// RoleSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
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

        // Create roles and assign permissions
        $roles = [
            'super_admin' => $permissions,
            'doctor' => [
                'create appointments',
                'edit appointments',
                'view appointments',
                'view doctors',
                'view patients',
                'create pharmacy',
                'view pharmacy',
                'edit pharmacy',
                'view reports',
          
            ],
            'patient' => [
                'create appointments',
                'view appointments',
                'view doctors',
                'view reports',
            ],
            'pharmacist' => [
                'view pharmacy',
                'create pharmacy',
                'edit pharmacy',
                'view reports',
            ],
            'user' => [
                'view appointments',
                'view reports',
            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::create(['name' => $roleName]);
            foreach ($rolePermissions as $permissionName) {
                $role->givePermissionTo($permissionName);
            }
        }
    }
}
