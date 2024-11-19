<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language; // استدعاء الموديل

class LanguagesTableSeeder extends Seeder
{
    public function run()
    {
        Language::create([
            'key' => 'en',
            'name' => 'English',
        ]);

        Language::create([
            'key' => 'ar',
            'name' => 'Arabic',
        ]);
    }
}
