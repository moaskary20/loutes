<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = [
            ['name' => 'الرياض', 'name_en' => 'Riyadh', 'code' => 'RIY', 'sort_order' => 1],
            ['name' => 'مكة المكرمة', 'name_en' => 'Makkah', 'code' => 'MAK', 'sort_order' => 2],
            ['name' => 'المدينة المنورة', 'name_en' => 'Madinah', 'code' => 'MAD', 'sort_order' => 3],
            ['name' => 'القصيم', 'name_en' => 'Qassim', 'code' => 'QAS', 'sort_order' => 4],
            ['name' => 'الشرقية', 'name_en' => 'Eastern Province', 'code' => 'EAS', 'sort_order' => 5],
            ['name' => 'عسير', 'name_en' => 'Asir', 'code' => 'ASI', 'sort_order' => 6],
            ['name' => 'تبوك', 'name_en' => 'Tabuk', 'code' => 'TAB', 'sort_order' => 7],
            ['name' => 'حائل', 'name_en' => 'Hail', 'code' => 'HAI', 'sort_order' => 8],
            ['name' => 'الحدود الشمالية', 'name_en' => 'Northern Borders', 'code' => 'NOR', 'sort_order' => 9],
            ['name' => 'جازان', 'name_en' => 'Jazan', 'code' => 'JAZ', 'sort_order' => 10],
            ['name' => 'نجران', 'name_en' => 'Najran', 'code' => 'NAJ', 'sort_order' => 11],
            ['name' => 'الباحة', 'name_en' => 'Al Baha', 'code' => 'BAH', 'sort_order' => 12],
            ['name' => 'الجوف', 'name_en' => 'Al Jawf', 'code' => 'JOU', 'sort_order' => 13],
        ];

        foreach ($provinces as $province) {
            Province::firstOrCreate(
                ['code' => $province['code']],
                $province
            );
        }
    }
}
