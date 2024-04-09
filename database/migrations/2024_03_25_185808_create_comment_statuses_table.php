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
        Schema::create('comment_statuses', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->string('value')->nullable(false);
            $table->string('label')->nullable(false);
            $table->boolean('is_active')->default(false);
            $table->timestamps();
            $table->foreignId('user_id')
                ->constrained()
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index(
                'user_id',
                'idx_users_comment_statuses_id'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_statuses');
        Schema::table('comment_statuses', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropIndex('idx_users_comment_statuses_id');
        });
    }
};
