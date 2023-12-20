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
        Schema::table('set_configuration_options', function (Blueprint $table) {
            $table->foreignId('configuration_column_id')
                ->constrained()
                ->on('set_configuration_columns')
                ->onDelete('cascade')
                ->onUpdate('cascade')
                ->index('idx_configuration_options_configuration_column_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('set_configuration_options', function (Blueprint $table) {
            $table->dropForeign(['configuration_column_id']);
            $table->dropColumn('configuration_column_id');
        });
    }
};
