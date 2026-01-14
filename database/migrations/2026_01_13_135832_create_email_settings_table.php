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
        Schema::create('email_settings', function (Blueprint $table) {
            $table->id();
            $table->string('provider')->default('brevo'); // brevo, smtp, etc.
            $table->string('brevo_api_key')->nullable();
            $table->string('from_email')->nullable();
            $table->string('from_name')->nullable();
            $table->string('admin_email')->nullable(); // البريد الإلكتروني الذي سيستقبل الإشعارات
            $table->boolean('enabled')->default(false);
            $table->boolean('send_notifications')->default(true); // إرسال الإشعارات عبر البريد
            $table->json('notification_types')->nullable(); // أنواع الإشعارات المراد إرسالها
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_settings');
    }
};
