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
        Schema::create('contact_me_messages', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->string('full_name');
            $table->string('email_address');
            $table->string('phone')->nullable();
            $table->string('subject');
            $table->string('message');
            $table->boolean('privacy_policy')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_me_messages');
    }
};
