<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'email' => 'doner@example.com',
            'password' => bcrypt('password'),
        ]);
        User::create([
            'email' => 'organization1@example.com',

            'password' => bcrypt('password'),
        ]);

        User::create([
            'email' => 'organization2@example.com',

            'password' => bcrypt('password'),
        ]);

        User::create([
            'email' => 'organization3@example.com',

            'password' => bcrypt('password'),
        ]);
    }
}
