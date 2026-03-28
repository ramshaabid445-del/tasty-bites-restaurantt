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
            'view dashboard', 'view reports', 'view pos',
            'manage staff', 'view attendance', 'manage users', // HR
            'manage menu', 'manage inventory', 'process payment'
        ];

        foreach ($permissions as $name) {
            Permission::create(['name' => $name, 'guard_name' => 'web']);
        }

        // Create Roles
        $superAdminRole = Role::create(['name' => 'Super Admin']);
        $managerRole = Role::create(['name' => 'Manager']);

        // Assign some permissions to Manager (but not all)
        $managerRole->givePermissionTo(['view dashboard', 'manage staff']);

        // Create a Test Super Admin User
        $user = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        
        $user->assignRole($superAdminRole);
    }
}