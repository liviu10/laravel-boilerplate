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
        Schema::create('tags', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->foreignId('content_id')
                ->constrained()
                ->on('contents')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index(
                'content_id',
                'idx_contents_tags_id'
            );
            $table->string('name')->nullable(false);
            $table->string('description')->nullable();
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('user_id')
                ->constrained()
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index(
                'user_id',
                'idx_users_tags_id'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
        Schema::table('tags', function (Blueprint $table) {
            $table->dropForeign(['content_id']);
            $table->dropColumn('content_id');
            $table->dropIndex('idx_contents_tags_id');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropIndex('idx_users_tags_id');
        });
    }
};
