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
        Schema::create('configuration_inputs', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->string('accept')->nullable();
            $table->string('field');
            $table->boolean('is_active')->default(false);
            $table->boolean('is_filter')->default(false);
            $table->boolean('is_model')->default(false);
            $table->string('key');
            $table->string('name');
            $table->integer('position');
            $table->enum('type', [
                'number',
                'textarea',
                'time',
                'text',
                'password',
                'email',
                'search',
                'tel',
                'file',
                'url',
                'date'
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuration_inputs');
    }
};
