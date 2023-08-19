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
        Schema::create('contents', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->enum('visibility', ['Public', 'Private', 'Draft']);
            $table->string('content_url')->nullable(false);
            $table->string('title')->nullable(false);
            $table->enum('content_type', ['Page', 'Article']);
            $table->string('description');
            $table->longText('content')->nullable(false);
            $table->boolean('allow_comments')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
