<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $permissions = [
        ['name' => 'View POS', 'slug' => 'view_pos'],
        ['name' => 'Manage Menu', 'slug' => 'manage_menu'],
        ['name' => 'View Reports', 'slug' => 'view_reports'],
        ['name' => 'Manage Staff', 'slug' => 'manage_staff'],
    ];

    foreach ($permissions as $p) {
        \App\Models\Permission::updateOrCreate(['slug' => $p['slug']], $p);
    }
}
}
