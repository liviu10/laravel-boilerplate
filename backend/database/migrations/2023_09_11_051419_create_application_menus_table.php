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
        Schema::create('application_menus', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->string('path');
            $table->string('name');
            $table->string('component');
            $table->string('layout');
            $table->string('title')->nullable();
            $table->string('caption')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('requires_auth')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_menus');
    }
};
