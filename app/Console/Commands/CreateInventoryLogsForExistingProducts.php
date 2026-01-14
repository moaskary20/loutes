<?php

namespace App\Console\Commands;

use App\Models\InventoryLog;
use App\Models\Product;
use Illuminate\Console\Command;

class CreateInventoryLogsForExistingProducts extends Command
{
    protected $signature = 'inventory:create-logs-for-existing-products';

    protected $description = 'إنشاء سجلات مخزون للمنتجات الموجودة التي لديها مخزون';

    public function handle()
    {
        $products = Product::where('stock_quantity', '>', 0)->get();
        
        if ($products->isEmpty()) {
            $this->info('لا توجد منتجات لديها مخزون.');
            return Command::SUCCESS;
        }

        $this->info("تم العثور على {$products->count()} منتج لديها مخزون.");
        
        $bar = $this->output->createProgressBar($products->count());
        $bar->start();

        $created = 0;
        foreach ($products as $product) {
            // التحقق من وجود سجل مخزون بالفعل لهذا المنتج
            $existingLog = InventoryLog::where('product_id', $product->id)
                ->where('reason', 'إضافة منتج جديد')
                ->first();

            if (!$existingLog) {
                // إنشاء السجل بدون تحديث المخزون (لأنه موجود بالفعل)
                InventoryLog::withoutEvents(function () use ($product, &$created) {
                    InventoryLog::create([
                        'product_id' => $product->id,
                        'quantity' => $product->stock_quantity,
                        'type' => 'in',
                        'reason' => 'إضافة منتج جديد',
                        'reference' => $product->sku,
                        'notes' => "إضافة منتج موجود: {$product->name} - الكمية الابتدائية: {$product->stock_quantity}",
                    ]);
                    $created++;
                });
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("تم إنشاء {$created} سجل مخزون جديد.");

        return Command::SUCCESS;
    }
}
