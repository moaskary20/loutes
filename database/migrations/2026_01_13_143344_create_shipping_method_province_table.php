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
        Schema::create('shipping_method_province', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipping_method_id')->constrained()->onDelete('cascade');
            $table->foreignId('province_id')->constrained()->onDelete('cascade');
            $table->decimal('cost', 10, 2)->default(0); // تكلفة الشحن لهذه المحافظة
            $table->timestamps();
            
            // منع التكرار
            $table->unique(['shipping_method_id', 'province_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_method_province');
    }
};
