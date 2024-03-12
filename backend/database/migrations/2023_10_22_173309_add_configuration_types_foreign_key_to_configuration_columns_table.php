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
        Schema::table('configuration_columns', function (Blueprint $table) {
            $table->foreignId('configuration_type_id')
                ->constrained()
                ->on('configuration_types')
                ->onDelete('cascade')
                ->onUpdate('cascade')
                ->index('idx_configuration_columns_configuration_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('configuration_columns', function (Blueprint $table) {
            $table->dropForeign(['configuration_type_id']);
            $table->dropColumn('configuration_type_id');
        });
    }
};
