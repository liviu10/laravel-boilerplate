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
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->foreignId('notification_type_id')
                ->constrained()
                ->on('notification_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index(
                'notification_type_id',
                'idx_notification_type_notification_template_id'
            );
            $table->foreignId('notification_condition_id')
                ->constrained()
                ->on('notification_conditions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index(
                'notification_condition_id',
                'idx_notification_condition_notification_template_id'
            );
            $table->string('title');
            $table->string('content');
            $table->foreignId('user_id')
                ->constrained()
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index(
                'user_id',
                'idx_users_notification_template_id'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_templates');
        Schema::table('notification_templates', function (Blueprint $table) {
            $table->dropForeign(['notification_type_id']);
            $table->dropColumn('notification_type_id');
            $table->dropIndex('idx_notification_type_notification_template_id');
            $table->dropForeign(['notification_condition_id']);
            $table->dropColumn('notification_condition_id');
            $table->dropIndex('idx_notification_condition_notification_template_id');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropIndex('idx_users_notification_template_id');
        });
    }
};
