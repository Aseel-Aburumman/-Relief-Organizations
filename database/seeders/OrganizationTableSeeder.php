<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;

class OrganizationTableSeeder extends Seeder
{
    public function run()
    {
        Organization::create([
            'email' => 'organization1@example.com',
            'password' => bcrypt('password'),
        ]);

        Organization::create([
            'email' => 'organization2@example.com',
            'password' => bcrypt('password'),
        ]);

        Organization::create([
            'email' => 'organization3@example.com',
            'password' => bcrypt('password'),
        ]);
      
    }
}

