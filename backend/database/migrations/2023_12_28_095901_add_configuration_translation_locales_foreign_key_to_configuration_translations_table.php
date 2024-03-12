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
        Schema::table('configuration_translations', function (Blueprint $table) {
            $table->foreignId('configuration_translation_locale_id')
                ->constrained()
                ->on('configuration_translation_locales')
                ->onDelete('cascade')
                ->onUpdate('cascade')
                ->index('idx_config_translations_config_translation_locale_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('configuration_translations', function (Blueprint $table) {
            $table->dropForeign(['configuration_translation_locale_id']);
            $table->dropColumn('configuration_translation_locale_id');
        });
    }
};
