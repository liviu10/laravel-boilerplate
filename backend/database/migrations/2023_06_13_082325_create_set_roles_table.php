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
        Schema::create('set_roles', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->string('name')->unique();
            $table->longText('description');
            $table->string('bg_color')->nullable();
            $table->string('text_color')->nullable();
            $table->string('slug');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('set_roles');
    }
};
