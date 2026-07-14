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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('address');
            $table->string('area'); // Batam Centre, Nagoya, Tiban, Sekupang, dll
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->json('operating_hours')->nullable(); // {"mon":"08:00-22:00","tue":"08:00-22:00",...}
            $table->integer('min_order')->default(0); // Minimum order dalam rupiah
            $table->integer('delivery_radius')->default(5); // Radius pengiriman dalam km
            $table->integer('estimated_time')->default(30); // Estimasi waktu dalam menit
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Owner/admin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
