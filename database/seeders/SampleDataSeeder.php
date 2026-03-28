<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\DiningTable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Dining Tables
        $tableCol = Schema::hasColumn('dining_tables', 'table_number') ? 'table_number' : 'name';
        
        DiningTable::updateOrCreate(
            [$tableCol => 'T-1'],
            ['capacity' => 4, 'status' => 'available']
        );
        DiningTable::updateOrCreate(
            [$tableCol => 'T-2'],
            ['capacity' => 2, 'status' => 'available']
        );

        // 2. Categories
        $fastfood = Category::updateOrCreate(['slug' => 'fast-food'], ['name' => 'Fast Food']);
        $drinks = Category::updateOrCreate(['slug' => 'drinks'], ['name' => 'Cold Drinks']);

        // 3. Menu Items (Adding Slugs and checking columns)
        $items = [
            ['name' => 'Zinger Burger', 'price' => 450, 'cat' => $fastfood->id],
            ['name' => 'Beef Burger', 'price' => 550, 'cat' => $fastfood->id],
            ['name' => 'Coke 500ml', 'price' => 120, 'cat' => $drinks->id],
        ];

        foreach ($items as $item) {
            $data = [
                'category_id' => $item['cat'],
                'price' => $item['price'],
            ];

            // Agar table mein 'slug' column hai toh name se slug banao
            if (Schema::hasColumn('menu_items', 'slug')) {
                $data['slug'] = Str::slug($item['name']);
            }

            // Agar table mein 'status' column hai
            if (Schema::hasColumn('menu_items', 'status')) {
                $data['status'] = 1;
            }

            MenuItem::updateOrCreate(['name' => $item['name']], $data);
        }
    }
}