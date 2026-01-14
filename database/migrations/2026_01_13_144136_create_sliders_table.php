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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); // عنوان الصورة
            $table->text('description')->nullable(); // وصف الصورة
            $table->string('image'); // مسار الصورة
            $table->string('link')->nullable(); // رابط عند النقر على الصورة
            $table->integer('sort_order')->default(0); // ترتيب العرض
            $table->boolean('is_active')->default(true); // نشط/غير نشط
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
