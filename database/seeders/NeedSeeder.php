<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NeedSeeder extends Seeder
{
    public function run()
    {
        DB::table('needs')->insert([
            [
                'organization_id' => 1,
                'category_id' => 2,
                'language_id' => 1,
                'item_name' => 'Blankets',
                'quantity_needed' => 100,
                'donated_quantity' => 20,
                'description' => 'Winter blankets needed for distribution.',
                'urgency' => 'High Priority',
                'status' => 'Available',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'organization_id' => 1,
                'category_id' => 3,
                'language_id' => 2,
                'item_name' => 'Food Packages',
                'quantity_needed' => 200,
                'donated_quantity' => 50,
                'description' => 'Essential food items for families.',
                'urgency' => 'Medium Priority',
                'status' => 'Partially Fulfilled',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'organization_id' => 2,
                'category_id' => 1,
                'language_id' => 1,
                'item_name' => 'School Supplies',
                'quantity_needed' => 50,
                'donated_quantity' => 30,
                'description' => 'School bags and stationery for students.',
                'urgency' => 'Low Priority',
                'status' => 'Fulfilled',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
