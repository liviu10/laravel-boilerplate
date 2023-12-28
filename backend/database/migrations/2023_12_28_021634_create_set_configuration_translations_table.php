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
        Schema::create('set_configuration_translations', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->string('locale')->unique();
            $table->string('key');
            $table->longText('translation');
            $table->integer('configuration_resource_id')->nullable();
            $table->integer('configuration_column_id')->nullable();
            $table->integer('configuration_input_id')->nullable();
            $table->integer('configuration_option_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('set_configuration_translations');
    }
};
