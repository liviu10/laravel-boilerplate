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
            $table->foreignId('comment_type_id')
                ->constrained()
                ->on('comment_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index(
                'comment_type_id',
                'idx_comment_types_comment_id'
            );
            $table->foreignId('comment_status_id')
                ->constrained()
                ->on('comment_status')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index(
                'comment_status_id',
                'idx_comment_status_comment_id'
            );
            $table->foreignId('content_id')
                ->constrained()
                ->on('contents')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index(
                'content_id',
                'idx_contents_comment_id'
            );
            $table->string('full_name')->nullable(false);
            $table->string('email');
            $table->string('message')->nullable(false);
            $table->boolean('notify_new_comments')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->integer('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['comment_type_id']);
            $table->dropColumn('comment_type_id');
            $table->dropIndex('idx_comment_types_comment_id');
            $table->dropForeign(['comment_status_id']);
            $table->dropColumn('comment_status_id');
            $table->dropIndex('idx_comment_status_comment_id');
            $table->dropForeign(['content_id']);
            $table->dropColumn('content_id');
            $table->dropIndex('idx_contents_comment_id');
        });
    }
};
