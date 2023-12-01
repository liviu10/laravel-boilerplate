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
        Schema::create('set_generals', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->enum('type', [
                'General',
                'Writing',
                'Reading',
                'Discussion',
                'Media',
                'Performance',
                'Notifications',
            ]);
            $table->string('label');
            $table->string('value');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('set_generals');
    }
};
