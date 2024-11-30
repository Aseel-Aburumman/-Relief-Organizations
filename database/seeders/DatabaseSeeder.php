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
            NeedDetailSeeder::class,
            PostsTableSeeder::class,
            PostImageTableSeeder::class,
            OrganizationImageTableSeeder::class,
            NeedImageTableSeeder::class,

            UserDetailTableSeeder::class,
            DonationSeeder::class,

            RoleAndPermissionSeeder::class,


        ]);
    }
}
