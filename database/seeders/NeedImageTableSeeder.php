<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NeedImage;

class NeedImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
        // إضافة صور تجريبية
        NeedImage::create([
            'need_id' => 1,
            'image' => 'blanket.jpg',
        ]);

        NeedImage::create([
            'need_id' => 2,
            'image' => 'food.jpg',
        ]);

        NeedImage::create([
            'need_id' => 3,
            'image' => 'medical_supplies.jpg',
        ]);
        NeedImage::create([
            'need_id' => 4,
            'image' => 'winter_jackets.jpg',
        ]);

        NeedImage::create([
            'need_id' => 5,
            'image' => 'first_aid_kits.jpg',
        ]);

        NeedImage::create([
            'need_id' => 6,
            'image' => 'tents.jpg',
        ]);
    }
}
