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
        Schema::create('contact_responses', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->foreignId('contact_message_id')
                ->constrained()
                ->on('contact_messages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index(
                'contact_message_id',
                'idx_contact_messages_contact_responses_id'
            );
            $table->string('message')->nullable(false);
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('user_id')
                ->constrained()
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index(
                'user_id',
                'idx_users_contact_responses_id'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_responses');
        Schema::table('contact_responses', function (Blueprint $table) {
            $table->dropForeign(['contact_message_id']);
            $table->dropColumn('contact_message_id');
            $table->dropIndex('idx_contact_messages_contact_responses_id');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropIndex('idx_users_contact_responses_id');
        });
    }
};
