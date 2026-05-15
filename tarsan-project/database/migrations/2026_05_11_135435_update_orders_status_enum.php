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
        // Update enum to include 'completed'
        DB::statement("ALTER TABLE orders MODIFY status ENUM('pending','confirmed','cancelled','completed') DEFAULT 'confirmed'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum
        DB::statement("ALTER TABLE orders MODIFY status ENUM('pending','confirmed','cancelled') DEFAULT 'confirmed'");
    }
};
