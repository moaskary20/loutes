<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('pending');
            $table->string('payment_status')->default('pending');
            $table->string('payment_method')->nullable();
            $table->foreignId('shipping_method_id')->nullable()->constrained('shipping_methods')->onDelete('set null');
            $table->foreignId('coupon_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->text('notes')->nullable();
            $table->json('shipping_address');
            $table->json('billing_address');
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
