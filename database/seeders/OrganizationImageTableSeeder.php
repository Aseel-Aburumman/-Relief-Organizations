<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrganizationImage;

class OrganizationImageTableSeeder extends Seeder
{
    public function run()
    {
        // إضافة صور تجريبية
        OrganizationImage::create([
            'organization_id' => 1,
            'image' => 'org1.png',
        ]);


        OrganizationImage::create([
            'organization_id' => 2,
            'image' => 'org2.jpg',
        ]);
        OrganizationImage::create([
            'organization_id' => 3,
            'image' => 'org3.png',
        ]);
    }
}
