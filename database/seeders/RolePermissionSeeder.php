<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Dashboard
            'view-dashboard',

            // Users
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',

            // Roles
            'view-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',

            // Permissions
            'view-permissions',
            'create-permissions',
            'edit-permissions',
            'delete-permissions',

            // Projects
            'view-projects',
            'create-projects',
            'edit-projects',
            'delete-projects',

            // Employees
            'view-employees',
            'create-employees',
            'edit-employees',
            'delete-employees',

            // Clients
            'view-clients',
            'create-clients',
            'edit-clients',
            'delete-clients',

            // Tasks
            'view-tasks',
            'create-tasks',
            'edit-tasks',
            'delete-tasks',

            // Tags
            'view-tags',
            'create-tags',
            'edit-tags',
            'delete-tags',

            // Settings
            'view-settings',
            'edit-settings',

            // User Management
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $manager = Role::firstOrCreate(['name' => 'manager']);
        $user = Role::firstOrCreate(['name' => 'user']);

        // Assign permissions to roles
        $superAdmin->givePermissionTo(Permission::all());

        $admin->givePermissionTo([
            'view-dashboard',
            'view-projects', 'create-projects', 'edit-projects', 'delete-projects',
            'view-employees', 'create-employees', 'edit-employees', 'delete-employees',
            'view-clients', 'create-clients', 'edit-clients', 'delete-clients',
            'view-tasks', 'create-tasks', 'edit-tasks', 'delete-tasks',
            'view-tags', 'create-tags', 'edit-tags', 'delete-tags',
            'view-settings', 'edit-settings',
        ]);

        $manager->givePermissionTo([
            'view-dashboard',
            'view-projects', 'create-projects', 'edit-projects',
            'view-employees', 'create-employees', 'edit-employees',
            'view-clients', 'create-clients', 'edit-clients',
            'view-tasks', 'create-tasks', 'edit-tasks',
            'view-tags', 'create-tags', 'edit-tags',
        ]);

        $user->givePermissionTo([
            'view-dashboard',
            'view-projects',
            'view-employees',
            'view-clients',
            'view-tasks',
            'view-tags',
        ]);

        // Create default super admin user
        $superAdminUser = User::firstOrCreate(
            ['email' => 'admin@darvag.com'],
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'password' => bcrypt('password'),
            ]
        );

        $superAdminUser->assignRole('super-admin');
    }
}
