<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DonationSeeder extends Seeder
{
    public function run()
    {
        DB::table('donations')->insert([
            [
                'need_id' => 1,
                'quantity' => 10,
                'donor_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'need_id' => 1,
                'quantity' => 10,
                'donor_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'need_id' => 2,
                'quantity' => 30,
                'donor_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'need_id' => 2,
                'quantity' => 20,
                'donor_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'need_id' => 3,
                'quantity' => 20,
                'donor_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'need_id' => 3,
                'quantity' => 10,
                'donor_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'need_id' => 4,
                'quantity' => 40,
                'donor_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'need_id' => 4,
                'quantity' => 30,
                'donor_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'need_id' => 5,
                'quantity' => 20,
                'donor_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'need_id' => 6,
                'quantity' => 13,
                'donor_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'need_id' => 6,
                'quantity' => 2,
                'donor_id' => 3,

                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
