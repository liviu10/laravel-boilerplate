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
        Schema::create('com_reviews', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->string('full_name');
            $table->integer('rating');
            $table->string('comment');
            $table->boolean('is_active')->default(false);
            $table->integer('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('com_reviews');
    }
};