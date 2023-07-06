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
        Schema::table('migration_filter_rules', function (Blueprint $table) {
            $table->foreignId('migration_filter_id')->constrained()->onDelete('cascade')->onUpdate('cascade')->index('idx_migration_filter_rule_migration_filter_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('migration_filter_rules', function (Blueprint $table) {
            $table->dropForeign(['migration_filter_id']);
            $table->dropColumn('migration_filter_id');
        });
    }
};
