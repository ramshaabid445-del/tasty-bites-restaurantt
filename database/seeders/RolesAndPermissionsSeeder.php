<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define All Permissions
        $permissions = [
            'view dashboard',
            'view pos',
            'view orders',
            'manage orders',
            'view kds',
            'manage menu',
            'manage inventory',
            'manage tables',
            'manage hr',
            'manage crm',
            'manage finance',
            'view reports',
            'manage settings',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        // Create Roles
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $managerRole = Role::firstOrCreate(['name' => 'Manager']);
        $staffRole = Role::firstOrCreate(['name' => 'Staff']);

        // Assign all permissions to Super Admin (though Gate::before handles it, it's good practice)
        $superAdminRole->syncPermissions(Permission::all());

        // Assign some permissions to Manager
        $managerRole->syncPermissions([
            'view dashboard',
            'view pos',
            'view orders',
            'manage orders',
            'view kds',
            'manage menu',
            'manage inventory',
            'manage tables',
            'manage crm',
            'view reports',
        ]);

        // Assign limited permissions to Staff
        $staffRole->syncPermissions([
            'view dashboard',
            'view pos',
            'view orders',
            'view kds',
        ]);

        // Create a Test Super Admin User if not exists
        $user = User::where('email', 'admin@example.com')->first();
        if (!$user) {
            $user = User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
            ]);
        }
        
        $user->assignRole($superAdminRole);
    }
}