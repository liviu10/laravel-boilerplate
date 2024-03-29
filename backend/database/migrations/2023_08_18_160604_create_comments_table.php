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
        Schema::create('comments', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->enum('type', ['Comment', 'Reply']);
            $table->enum('status', ['Pending', 'Approved', 'Spam', 'Trash']);
            $table->string('full_name')->nullable(false);
            $table->string('email');
            $table->string('message')->nullable(false);
            $table->boolean('notify_new_comments')->default(false);
            $table->integer('content_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
