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
        Schema::create('content_social_media', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->foreignId('content_id')
                ->constrained()
                ->on('contents')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index(
                'content_id',
                'idx_contents_content_social_media_id'
            );
            $table->string('platform_name')->nullable(false);
            $table->string('full_share_url')->nullable(false);
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('user_id')
                ->constrained()
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index(
                'user_id',
                'idx_users_content_social_media_id'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_social_media');
        Schema::table('content_social_media', function (Blueprint $table) {
            $table->dropForeign(['content_id']);
            $table->dropColumn('content_id');
            $table->dropIndex('idx_contents_content_social_media_id');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropIndex('idx_users_content_social_media_id');
        });
    }
};
