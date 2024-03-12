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
        Schema::create('configuration_columns', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->string('align');
            $table->string('field');
            $table->string('header_style');
            $table->string('label');
            $table->string('name');
            $table->integer('position');
            $table->string('style');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuration_columns');
    }
};
