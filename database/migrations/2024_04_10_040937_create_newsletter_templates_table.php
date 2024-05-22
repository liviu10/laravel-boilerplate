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
        Schema::create('newsletter_templates', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->foreignId('newsletter_campaign_id')
                ->constrained()
                ->on('newsletter_campaigns')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index(
                'newsletter_campaign_id',
                'idx_newsletter_campaigns_newsletter_templates_id'
            );
            $table->string('path')->nullable(false);
            $table->longText('template')->nullable(false);
            $table->boolean('is_active')->default(false);
            $table->foreignId('user_id')
                ->constrained()
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index(
                'user_id',
                'idx_users_newsletter_templates_id'
            );
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletter_templates');
        Schema::table('newsletter_templates', function (Blueprint $table) {
            $table->dropForeign(['newsletter_campaign_id']);
            $table->dropColumn('newsletter_campaign_id');
            $table->dropIndex('idx_newsletter_campaigns_newsletter_templates_id');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropIndex('idx_users_newsletter_templates_id');
        });
    }
};
