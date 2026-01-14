<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'إلكترونيات', 'slug' => 'electronics', 'is_active' => true, 'sort_order' => 1],
            ['name' => 'ملابس', 'slug' => 'clothing', 'is_active' => true, 'sort_order' => 2],
            ['name' => 'أثاث', 'slug' => 'furniture', 'is_active' => true, 'sort_order' => 3],
            ['name' => 'كتب', 'slug' => 'books', 'is_active' => true, 'sort_order' => 4],
            ['name' => 'ألعاب', 'slug' => 'toys', 'is_active' => true, 'sort_order' => 5],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
