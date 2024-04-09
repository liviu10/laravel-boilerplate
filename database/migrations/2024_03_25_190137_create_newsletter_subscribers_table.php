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
        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->foreignId('newsletter_campaign_id')
                ->constrained()
                ->on('newsletter_campaigns')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index(
                'newsletter_campaign_id',
                'idx_newsletter_campaigns_newsletter_subscribers_id'
            );
            $table->string('full_name')->nullable(false);
            $table->string('email')->nullable(false);
            $table->boolean('privacy_policy')->default(false);
            $table->boolean('valid_email')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletter_subscribers');
        Schema::table('newsletter_subscribers', function (Blueprint $table) {
            $table->dropForeign(['newsletter_campaign_id']);
            $table->dropColumn('newsletter_campaign_id');
            $table->dropIndex('idx_newsletter_campaigns_newsletter_subscribers_id');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropIndex('idx_users_newsletter_campaigns_id');
        });
    }
};
