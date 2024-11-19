<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PostsTableSeeder::class,
            LanguagesTableSeeder::class, 
            ImagesTableSeeder::class,
            UsersTableSeeder::class,
            OrganizationTableSeeder::class,
            UserDetailTableSeeder::class,


        ]);
    }
}
