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
                'quantity_needed' => 100,
                'donated_quantity' => 20,
                'urgency' => 'High Priority',
                'status' => 'Available',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'organization_id' => 1,
                'category_id' => 1, // Food
                'quantity_needed' => 200,
                'donated_quantity' => 50,
                'urgency' => 'Medium Priority',
                'status' => 'Partially Fulfilled',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'organization_id' => 2,
                'category_id' => 5, // Medical Equipment
                'quantity_needed' => 50,
                'donated_quantity' => 30,
                'urgency' => 'Low Priority',
                'status' => 'Fulfilled',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'organization_id' => 2,
                'category_id' => 4, // Clothing
                'quantity_needed' => 150,
                'donated_quantity' => 70,
                'urgency' => 'High Priority',
                'status' => 'Partially Fulfilled',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'organization_id' => 3,
                'category_id' => 2, // Medicine
                'quantity_needed' => 80,
                'donated_quantity' => 20,
                'urgency' => 'Medium Priority',
                'status' => 'Available',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'organization_id' => 3,
                'category_id' => 3, // Shelter (tents, blankets)
                'quantity_needed' => 40,
                'donated_quantity' => 15,
                'urgency' => 'High Priority',
                'status' => 'Partially Fulfilled',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
