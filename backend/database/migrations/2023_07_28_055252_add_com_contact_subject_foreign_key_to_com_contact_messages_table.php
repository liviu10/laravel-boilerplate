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
        Schema::table('com_contact_messages', function (Blueprint $table) {
            $table->foreignId('contact_subject_id')
                ->constrained()
                ->on('com_contact_subjects')
                ->onDelete('cascade')
                ->onUpdate('cascade')
                ->index('idx_contact_messages_contact_subject_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('com_contact_messages', function (Blueprint $table) {
            $table->dropForeign(['contact_subject_id']);
            $table->dropColumn('contact_subject_id');
        });
    }
};
