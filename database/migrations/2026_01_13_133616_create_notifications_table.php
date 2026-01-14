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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // NotificationType enum
            $table->string('title');
            $table->text('message');
            $table->string('target_type')->nullable(); // 'admin', 'customer', 'all'
            $table->foreignId('target_id')->nullable(); // user_id or customer_id
            $table->foreignId('related_id')->nullable(); // order_id, product_id, coupon_id, etc.
            $table->string('related_type')->nullable(); // 'order', 'product', 'coupon', etc.
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->json('data')->nullable(); // Additional data
            $table->timestamps();
            
            $table->index(['target_type', 'target_id']);
            $table->index(['related_type', 'related_id']);
            $table->index('is_read');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
