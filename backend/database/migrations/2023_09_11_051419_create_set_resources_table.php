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
        Schema::create('set_resources', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->enum('type', ['Menu', 'API']);
            $table->string('path');
            $table->string('name')->nullable();
            $table->string('component')->nullable();
            $table->string('layout')->nullable();
            $table->string('title')->nullable();
            $table->string('caption')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('requires_auth')->default(false);
            $table->integer('position')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('set_resources');
    }
};
