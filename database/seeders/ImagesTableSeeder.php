<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('images')->insert([
            [
                'need_id' => 1,
                'organization_id' => 1,
                'post_id' => null,
                'image' => 'blanket.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'need_id' => 2,
                'organization_id' => 1,
                'post_id' => null,
                'image' => 'food.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'need_id' => 3,
                'organization_id' => 1,
                'post_id' => null,
                'image' => 'medical_supplies.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'need_id' => 4,
                'organization_id' => 1,
                'post_id' => null,
                'image' => 'winter_jackets.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'need_id' => 5,
                'organization_id' => 1,
                'post_id' => null,
                'image' => 'first_aid_kits.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'need_id' => 6,
                'organization_id' => 1,
                'post_id' => null,
                'image' => 'tents.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
