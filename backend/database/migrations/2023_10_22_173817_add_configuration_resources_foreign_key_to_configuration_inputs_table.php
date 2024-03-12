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
        Schema::table('configuration_inputs', function (Blueprint $table) {
            $table->foreignId('configuration_resource_id')
                ->constrained()
                ->on('configuration_resources')
                ->onDelete('cascade')
                ->onUpdate('cascade')
                ->index('idx_configuration_inputs_configuration_resource_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('configuration_inputs', function (Blueprint $table) {
            $table->dropForeign(['configuration_resource_id']);
            $table->dropColumn('configuration_resource_id');
        });
    }
};
