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
            // PostsTableSeeder::class,
            // ImagesTableSeeder::class,
            NeedSeeder::class,
            PostsTableSeeder::class,
            LanguagesTableSeeder::class,
            ImagesTableSeeder::class,
            UsersTableSeeder::class,
            OrganizationTableSeeder::class,
            UserDetailTableSeeder::class,


        ]);
    }
}
