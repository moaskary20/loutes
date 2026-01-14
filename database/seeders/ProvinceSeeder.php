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
            ['name' => 'القاهرة', 'name_en' => 'Cairo', 'code' => 'CAI', 'sort_order' => 1],
            ['name' => 'الجيزة', 'name_en' => 'Giza', 'code' => 'GIZ', 'sort_order' => 2],
            ['name' => 'الإسكندرية', 'name_en' => 'Alexandria', 'code' => 'ALX', 'sort_order' => 3],
            ['name' => 'الدقهلية', 'name_en' => 'Dakahlia', 'code' => 'DAK', 'sort_order' => 4],
            ['name' => 'البحيرة', 'name_en' => 'Beheira', 'code' => 'BEH', 'sort_order' => 5],
            ['name' => 'المنيا', 'name_en' => 'Minya', 'code' => 'MIN', 'sort_order' => 6],
            ['name' => 'أسيوط', 'name_en' => 'Asyut', 'code' => 'ASY', 'sort_order' => 7],
            ['name' => 'سوهاج', 'name_en' => 'Sohag', 'code' => 'SOH', 'sort_order' => 8],
            ['name' => 'قنا', 'name_en' => 'Qena', 'code' => 'QEN', 'sort_order' => 9],
            ['name' => 'الأقصر', 'name_en' => 'Luxor', 'code' => 'LUX', 'sort_order' => 10],
            ['name' => 'أسوان', 'name_en' => 'Aswan', 'code' => 'ASW', 'sort_order' => 11],
            ['name' => 'الشرقية', 'name_en' => 'Sharqia', 'code' => 'SHA', 'sort_order' => 12],
            ['name' => 'الغربية', 'name_en' => 'Gharbia', 'code' => 'GHA', 'sort_order' => 13],
            ['name' => 'كفر الشيخ', 'name_en' => 'Kafr El Sheikh', 'code' => 'KAF', 'sort_order' => 14],
            ['name' => 'المنوفية', 'name_en' => 'Monufia', 'code' => 'MON', 'sort_order' => 15],
            ['name' => 'الفيوم', 'name_en' => 'Faiyum', 'code' => 'FAI', 'sort_order' => 16],
            ['name' => 'بني سويف', 'name_en' => 'Beni Suef', 'code' => 'BEN', 'sort_order' => 17],
            ['name' => 'الإسماعيلية', 'name_en' => 'Ismailia', 'code' => 'ISM', 'sort_order' => 18],
            ['name' => 'بورسعيد', 'name_en' => 'Port Said', 'code' => 'POR', 'sort_order' => 19],
            ['name' => 'السويس', 'name_en' => 'Suez', 'code' => 'SUE', 'sort_order' => 20],
            ['name' => 'شمال سيناء', 'name_en' => 'North Sinai', 'code' => 'NSI', 'sort_order' => 21],
            ['name' => 'جنوب سيناء', 'name_en' => 'South Sinai', 'code' => 'SSI', 'sort_order' => 22],
            ['name' => 'البحر الأحمر', 'name_en' => 'Red Sea', 'code' => 'RED', 'sort_order' => 23],
            ['name' => 'الوادي الجديد', 'name_en' => 'New Valley', 'code' => 'NEW', 'sort_order' => 24],
            ['name' => 'مطروح', 'name_en' => 'Matruh', 'code' => 'MAT', 'sort_order' => 25],
            ['name' => 'دمياط', 'name_en' => 'Damietta', 'code' => 'DAM', 'sort_order' => 26],
            ['name' => 'القليوبية', 'name_en' => 'Qalyubia', 'code' => 'QAL', 'sort_order' => 27],
        ];

        foreach ($provinces as $province) {
            Province::firstOrCreate(
                ['code' => $province['code']],
                $province
            );
        }
    }
}
