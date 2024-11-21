<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostImage;

class PostImageTableSeeder extends Seeder
{
    public function run()
    {
        // إضافة صور تجريبية
        PostImage::create([
            'post_id' => 1,

            'image' => 'post_1.png',
        ]);

        PostImage::create([
            'post_id' => 1,
            'image' => 'post_1.png',
        ]);

        PostImage::create([
            'post_id' => 2,
            'image' => 'post_2.png',
        ]);
    }
}
