<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NeedImage;

class NeedImageTableSeeder extends Seeder
{
    public function run()
    {
        // إضافة صور تجريبية
        NeedImage::create([
            'need_id' => 1,
            'image' => 'post_1.png',
        ]);

        NeedImage::create([
            'need_id' => 1,
            'image' => 'post_1.png',
        ]);

        NeedImage::create([
            'need_id' => null,
            'image' => 'post_2.png',
        ]);
    }
}
