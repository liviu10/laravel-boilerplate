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
        Schema::table('contact_me_messages', function (Blueprint $table) {
            $table->foreignId('contact_me_subject_id')->constrained()->onDelete('cascade')->onUpdate('cascade')->index('idx_contact_me_messages_contact_me_subject_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_me_messages', function (Blueprint $table) {
            $table->dropForeign(['contact_me_subject_id']);
            $table->dropColumn('contact_me_subject_id');
        });
    }
};
