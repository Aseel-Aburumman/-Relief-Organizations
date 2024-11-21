<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrgnizationImage;

class OrgnizationImageTableSeeder extends Seeder
{
    public function run()
    {
        // إضافة صور تجريبية
        OrgnizationImage::create([
            'organization_id' => 1,
            'image' => 'post_1.png',
        ]);


        OrgnizationImage::create([
            'organization_id' => 2,
            'image' => 'post_2.png',
        ]);
    }
}
