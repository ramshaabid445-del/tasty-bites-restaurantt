<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Employee; // Employee model zaroor add karein
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Define All Permissions
        $permissions = [
            'view dashboard', 'view pos', 'view orders', 'manage orders',
            'view kds', 'manage menu', 'manage inventory', 'manage tables',
            'manage hr', 'manage crm', 'manage finance', 'view reports', 'manage settings',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        // 2. Create Roles
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $managerRole = Role::firstOrCreate(['name' => 'Manager', 'guard_name' => 'web']);
        $staffRole = Role::firstOrCreate(['name' => 'Staff', 'guard_name' => 'web']);

        // Assign permissions
        $superAdminRole->syncPermissions(Permission::all());
        $managerRole->syncPermissions(['view dashboard', 'view pos', 'view orders', 'manage orders', 'view kds', 'view reports']);
        $staffRole->syncPermissions(['view dashboard', 'view pos', 'view orders', 'view kds']);

        // 3. Create Super Admin User
        $user = User::where('email', 'admin@example.com')->first();
        if (!$user) {
            $user = User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin' // Aapke migration ke mutabiq
            ]);
        }
        $user->assignRole($superAdminRole);

        // 4. RESTORE STAFF MEMBERS (Jo fresh migrate se urr gaye thay)
        $employees = [
            ['name' => 'Zehaan Ali', 'email' => 'zee@example.com', 'phone' => '+92 333 9876543', 'designation' => 'Waiter', 'salary' => 25000],
            ['name' => 'Sana Ahmed', 'email' => 'sana.a@example.com', 'phone' => '+92 321 7654322', 'designation' => 'Floor Manager', 'salary' => 55000],
            ['name' => 'Arsalan Khan', 'email' => 'arsalan@example.com', 'phone' => '+92 300 1234586', 'designation' => 'Head Chef', 'salary' => 85000],
            ['name' => 'Hamza Malik', 'email' => 'hamza@example.com', 'phone' => '+92 312 1112233', 'designation' => 'Kitchen Helper', 'salary' => 20000],
        ];

        foreach ($employees as $emp) {
            Employee::firstOrCreate(
                ['email' => $emp['email']], // Duplicate rokne ke liye
                [
                    'name' => $emp['name'],
                    'phone' => $emp['phone'],
                    'designation' => $emp['designation'],
                    'salary' => $emp['salary'],
                    'joining_date' => now()->toDateString(),
                ]
            );
        }
    }
}