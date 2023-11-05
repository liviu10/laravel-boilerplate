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
        Schema::table('set_resource_children', function (Blueprint $table) {
            $table->foreignId('resource_id')
                ->constrained()
                ->on('set_resource_children')
                ->onDelete('cascade')
                ->onUpdate('cascade')
                ->index('idx_resources_resource_children_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('set_resource_children', function (Blueprint $table) {
            $table->dropForeign(['resource_id']);
            $table->dropColumn('resource_id');
        });
    }
};
