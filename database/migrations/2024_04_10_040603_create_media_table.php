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
        Schema::create('media', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->foreignId('media_type_id')
                ->constrained()
                ->on('media_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index(
                'media_type_id',
                'idx_media_types_media_id'
            );
            $table->foreignId('content_id')
                ->constrained()
                ->on('contents')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index(
                'content_id',
                'idx_contents_media_id'
            );
            $table->string('internal_path')->nullable();
            $table->string('external_path')->nullable();
            $table->string('title')->nullable();
            $table->string('caption')->nullable();
            $table->string('alt_text')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('user_id')
                ->constrained()
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index(
                'user_id',
                'idx_users_media_id'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
        Schema::table('media', function (Blueprint $table) {
            $table->dropForeign(['media_type_id']);
            $table->dropColumn('media_type_id');
            $table->dropIndex('idx_media_types_media_id');
            $table->dropForeign(['content_id']);
            $table->dropColumn('content_id');
            $table->dropIndex('idx_contents_media_id');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropIndex('idx_users_media_id');
        });
    }
};
