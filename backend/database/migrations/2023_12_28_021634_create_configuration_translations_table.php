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
        Schema::create('configuration_translations', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->string('key');
            $table->longText('translation');
            $table->string('related_model_name')->nullable();
            $table->integer('related_model_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuration_translations');
    }
};
