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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
        
            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnDelete();
        
            $table->tinyInteger('rating'); // 1 - 5
            $table->text('review');
            $table->text('admin_reply')->nullable();
        
            $table->timestamps();
        
            // 1 order hanya boleh 1 review
            $table->unique('order_id');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
