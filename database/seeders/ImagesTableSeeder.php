<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Image;

class ImagesTableSeeder extends Seeder
{
    public function run()
    {
        // إضافة صور تجريبية
        Image::create([
            'post_id' => 1,
            'need_id' => 1,
            'image' => 'post_1.png',
        ]);

        Image::create([
            'post_id' => 1,
            'need_id' => 1,
            'image' => 'post_1.png',
        ]);

        Image::create([
            'post_id' => 2,
            'need_id' => null,
            'image' => 'post_2.png',
        ]);
    }
}
