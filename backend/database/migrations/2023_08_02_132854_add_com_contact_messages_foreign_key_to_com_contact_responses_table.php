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
        Schema::table('com_contact_responses', function (Blueprint $table) {
            $table->foreignId('contact_message_id')->constrained()->on('com_contact_messages')->onDelete('cascade')->onUpdate('cascade')->index('idx_contact_responses_contact_messages_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('com_contact_responses', function (Blueprint $table) {
            $table->dropForeign(['contact_message_id']);
            $table->dropColumn('contact_message_id');
        });
    }
};
