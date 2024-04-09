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
        Schema::create('appreciations', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->foreignId('content_id')
                ->constrained()
                ->on('contents')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index(
                'content_id',
                'idx_contents_appreciation_id'
            );
            $table->integer('user_id')->nullable();
            $table->integer('likes')->nullable();
            $table->integer('dislikes')->nullable();
            $table->integer('rating')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appreciations');
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['content_id']);
            $table->dropColumn('content_id');
            $table->dropIndex('idx_contents_appreciation_id');
        });
    }
};
