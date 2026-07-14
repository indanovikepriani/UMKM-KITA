<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Just modify order_id to nullable directly - MySQL allows NULL in unique indexes
        DB::statement('ALTER TABLE reviews MODIFY order_id BIGINT UNSIGNED NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE reviews MODIFY order_id BIGINT UNSIGNED NOT NULL');
    }
};
