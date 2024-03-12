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
        Schema::create('newsletter_campaigns', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->string('name');
            $table->string('description');
            $table->boolean('is_active')->default(false);
            $table->dateTime('valid_from');
            $table->dateTime('valid_to');
            $table->integer('occur_times');
            $table->integer('occur_week');
            $table->integer('occur_day');
            $table->time('occur_hour');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletter_campaigns');
    }
};
