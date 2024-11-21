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
                'language_id' => 2,
                'item_name' => 'Food Packages',
                'description' => 'Essential food items for families.',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'need_id' => 3,
                'language_id' => 1,
                'item_name' => 'School Supplies',
                'description' => 'School bags and stationery for students.',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
