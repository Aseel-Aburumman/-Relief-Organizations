<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NeedDetailSeeder extends Seeder
{
    public function run()
    {
        DB::table('needDetails')->insert([
            [
                'need_id' => 1,
                'language_id' => 1,
                'item_name' => 'Blankets',
                'description' => 'Winter blankets needed for distribution.',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'need_id' => 2,
                'language_id' => 1,
                'item_name' => 'Food Packages',
                'description' => 'Essential food items for families.',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'need_id' => 3,
                'language_id' => 1,
                'item_name' => 'Medical Supplies',
                'description' => 'Medical Supplies for people.',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'need_id' => 4,
                'language_id' => 1,
                'item_name' => 'Clothing',
                'description' => 'Warm clothes for children and adults.',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'need_id' => 5,
                'language_id' => 1,
                'item_name' => 'First Aid Kits',
                'description' => 'Basic first aid kits for emergencies.',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'need_id' => 6,
                'language_id' => 1,
                'item_name' => 'Tents',
                'description' => 'Temporary shelters for displaced families.',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
