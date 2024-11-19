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
            'image' => 'images/post1_image1.jpg',
        ]);

        Image::create([
            'post_id' => 1,
            'need_id' => 1,
            'image' => 'images/post1_image2.jpg',
        ]);

        Image::create([
            'post_id' => 2, 
            'need_id' => null,
            'image' => 'images/post2_image1.jpg',
        ]);
    }
}
