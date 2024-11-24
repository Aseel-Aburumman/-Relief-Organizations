<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserDetail;

class UserDetailTableSeeder extends Seeder
{
    public function run()
    {
        UserDetail::create([
            'name' => 'organization1 User',
            'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nemo repudiandae pariatur beatae velit id magni, saepe ducimus atque exercitationem maiores rem alias, totam explicabo natus!',
            'organization_id' => '1',
            'language_id' => '1',
            'address' => 'Amman',
        ]);

        UserDetail::create([
            'name' => 'منظمة رقم 1',
            'description' => 'منظمة خيرية لعمل الخير في العالم',
            'organization_id' => '1',
            'language_id' => '2',
            'address' => 'عمان',
        ]);

        UserDetail::create([
            'name' => 'organization2 User',
            'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nemo repudiandae pariatur beatae velit id magni, saepe ducimus atque exercitationem maiores rem alias, totam explicabo natus!',
            'organization_id' => '2',
            'language_id' => '1',
            'address' => 'Amman',
        ]);

        UserDetail::create([
            'name' => 'منظمة رقم 2',
            'description' => 'منظمة خيرية2 لعمل الخير في العالم',
            'organization_id' => '2',
            'language_id' => '2',
            'address' => 'عمان',
        ]);

        UserDetail::create([
            'name' => 'organization3 User',
            'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nemo repudiandae pariatur beatae velit id magni, saepe ducimus atque exercitationem maiores rem alias, totam explicabo natus!',
            'organization_id' => '3',
            'language_id' => '1',
            'address' => 'Amman',
        ]);

        UserDetail::create([
            'name' => 'منظمة رقم 3',
            'description' => 'منظمة خيرية 3 لعمل الخير في العالم',
            'organization_id' => '3',
            'language_id' => '2',
            'address' => 'عمان',
        ]);


        UserDetail::create([
            'name' => 'user User',
            'user_id' => '2',
            'language_id' => '1',
            'address' => 'Amman',
        ]);

        UserDetail::create([
            'name' => 'عضو ',
            'user_id' => '2',
            'language_id' => '2',
            'address' => 'عمان',
        ]);


        UserDetail::create([
            'name' => 'doner User',
            'user_id' => '3',
            'language_id' => '1',
            'address' => 'Amman',
        ]);

        UserDetail::create([
            'name' => ' عضو متبرع',
            'user_id' => '3',
            'language_id' => '2',
            'address' => 'عمان',
        ]);
    }
}
