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
            LanguagesTableSeeder::class,
            CategorySeeder::class,
            UsersTableSeeder::class,
            OrganizationTableSeeder::class,
            NeedSeeder::class,
            PostsTableSeeder::class,
            ImagesTableSeeder::class,
            UserDetailTableSeeder::class,

        ]);
    }
}
