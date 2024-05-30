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
            $table->foreignId('content_visibility_id')
                ->constrained()
                ->on('content_visibilities')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index(
                'content_visibility_id',
                'idx_content_visibility_contents_id'
            );
            $table->string('content_url')->nullable(false);
            $table->string('title')->nullable(false);
            $table->foreignId('content_type_id')
                ->constrained()
                ->on('content_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index(
                'content_type_id',
                'idx_content_types_contents_id'
            );
            $table->integer('content_category_id')->nullable();
            $table->string('description')->nullable();
            $table->longText('content')->nullable(false);
            $table->boolean('allow_comments')->default(false);
            $table->boolean('allow_share')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('user_id')
                ->constrained()
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index(
                'user_id',
                'idx_users_contents_id'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
        Schema::table('contents', function (Blueprint $table) {
            $table->dropForeign(['content_visibility_id']);
            $table->dropColumn('content_visibility_id');
            $table->dropIndex('idx_content_visibility_contents_id');
            $table->dropForeign(['content_type_id']);
            $table->dropColumn('content_type_id');
            $table->dropIndex('idx_content_types_contents_id');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropIndex('idx_users_contents_id');
        });
    }
};
