<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('needs')->insert([
            [
                'organization_id' => 1,
                'category_id' => 2,
                'item_name' => 'Blankets',
                'item_name_ar' => 'بطانيات',
                'quantity_needed' => 100,
                'description' => 'Winter blankets needed for distribution.',
                'description_ar' => 'بطانيات شتوية للتوزيع.',
                'urgency' => 'High Priority', // Matches the allowed ENUM value
                'status' => 'Available', // Matches the allowed ENUM value
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'organization_id' => 1,
                'category_id' => 3,
                'item_name' => 'Food Packages',
                'item_name_ar' => 'طرود غذائية',
                'quantity_needed' => 200,
                'description' => 'Essential food items for families.',
                'description_ar' => 'مواد غذائية أساسية للعائلات.',
                'urgency' => 'Medium Priority', // Matches the allowed ENUM value
                'status' => 'Partially Fulfilled', // Matches the allowed ENUM value
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'organization_id' => 2,
                'category_id' => 4,
                'item_name' => 'School Supplies',
                'item_name_ar' => 'مستلزمات مدرسية',
                'quantity_needed' => 50,
                'description' => 'School bags and stationery for students.',
                'description_ar' => 'حقائب مدرسية وقرطاسية للطلاب.',
                'urgency' => 'Low Priority', // Matches the allowed ENUM value
                'status' => 'Fulfilled', // Matches the allowed ENUM value
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
