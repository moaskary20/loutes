<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->warn('لا توجد فئات. يرجى تشغيل CategorySeeder أولاً.');
            return;
        }

        $products = [
            [
                'name' => 'هاتف ذكي',
                'slug' => 'smartphone',
                'sku' => 'PHONE-001',
                'price' => 1500.00,
                'compare_price' => 1800.00,
                'stock_quantity' => 50,
                'category_id' => $categories->first()->id,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'لابتوب',
                'slug' => 'laptop',
                'sku' => 'LAPTOP-001',
                'price' => 3500.00,
                'compare_price' => 4000.00,
                'stock_quantity' => 30,
                'category_id' => $categories->first()->id,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'قميص رجالي',
                'slug' => 'mens-shirt',
                'sku' => 'SHIRT-001',
                'price' => 150.00,
                'compare_price' => 200.00,
                'stock_quantity' => 100,
                'category_id' => $categories->skip(1)->first()->id,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
