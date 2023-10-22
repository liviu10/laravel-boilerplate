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
        Schema::table('com_newsletter_subscribers', function (Blueprint $table) {
            $table->foreignId('newsletter_campaign_id')
                ->constrained()
                ->on('com_newsletter_campaigns')
                ->onDelete('cascade')
                ->onUpdate('cascade')
                ->index('idx_newsletter_subscribers_newsletter_campaign_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('com_newsletter_subscribers', function (Blueprint $table) {
            $table->dropForeign(['newsletter_campaign_id']);
            $table->dropColumn('newsletter_campaign_id');
        });
    }
};
