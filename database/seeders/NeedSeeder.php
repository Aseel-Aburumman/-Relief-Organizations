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
                'category_id' => 3, // Shelter (tents, blankets)
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
                'category_id' => 1, // Food
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
                'category_id' => 5, // Medical Equipment
                'language_id' => 1,
                'item_name' => 'Medical Supplies',
                'quantity_needed' => 50,
                'donated_quantity' => 30,
                'description' => 'Medical Supplies for people.',
                'urgency' => 'Low Priority',
                'status' => 'Fulfilled',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'organization_id' => 2,
                'category_id' => 4, // Clothing
                'language_id' => 2,
                'item_name' => 'Winter Jackets',
                'quantity_needed' => 150,
                'donated_quantity' => 70,
                'description' => 'Warm jackets needed for children.',
                'urgency' => 'High Priority',
                'status' => 'Partially Fulfilled',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'organization_id' => 3,
                'category_id' => 2, // Medicine
                'language_id' => 1,
                'item_name' => 'First Aid Kits',
                'quantity_needed' => 80,
                'donated_quantity' => 20,
                'description' => 'Basic first aid kits for emergency use.',
                'urgency' => 'Medium Priority',
                'status' => 'Available',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'organization_id' => 3,
                'category_id' => 3, // Shelter (tents, blankets)
                'language_id' => 1,
                'item_name' => 'Tents',
                'quantity_needed' => 40,
                'donated_quantity' => 15,
                'description' => 'Temporary shelters for displaced families.',
                'urgency' => 'High Priority',
                'status' => 'Partially Fulfilled',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
