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
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->foreignId('contact_subject_id')
                ->constrained()
                ->on('contact_subjects')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index(
                'contact_subject_id',
                'idx_contact_subjects_contact_messages_id'
            );
            $table->string('full_name')->nullable(false);
            $table->string('email')->nullable(false);
            $table->string('phone')->nullable();
            $table->boolean('privacy_policy')->default(false);
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
        Schema::dropIfExists('contact_messages');
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropForeign(['contact_subject_id']);
            $table->dropColumn('contact_subject_id');
            $table->dropIndex('idx_contact_subjects_contact_messages_id');
        });
    }
};
