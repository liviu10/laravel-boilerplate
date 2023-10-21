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
        Schema::create('set_notifications', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->enum('type', ['SMS', 'Email']);
            $table->enum('condition', ['Read', 'Create', 'Show', 'Update', 'Delete', 'Restore']);
            $table->string('title');
            $table->longText('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('set_notifications');
    }
};
