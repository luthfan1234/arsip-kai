<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view documents',
            'create documents',
            'edit documents',
            'delete documents',
            'download documents',
            'manage divisions',
            'manage categories',
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Assign permissions to admin (all permissions)
        $adminRole->syncPermissions($permissions);

        // Assign permissions to user (limited permissions)
        $userRole->syncPermissions([
            'view documents',
            'download documents',
        ]);
    }
}
