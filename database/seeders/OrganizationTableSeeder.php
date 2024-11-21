<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;

class OrganizationTableSeeder extends Seeder
{
    public function run()
    {
        Organization::create([
            'user_id' => '4',
            'contact_info' => '079656585',
            'certificate_image' => 'post_1.png',
            'status' => 'Approved',
        ]);

        Organization::create([
            'user_id' => '5',
            'contact_info' => '079656585',
            'certificate_image' => 'post_1.png',
            'status' => 'Approved',

        ]);

        Organization::create([
            'user_id' => '6',
            'contact_info' => '079656585',
            'certificate_image' => 'post_1.png',
            'status' => 'Approved',

        ]);
    }
}
