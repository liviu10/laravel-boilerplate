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
        Schema::table('man_medias', function (Blueprint $table) {
            $table->foreignId('content_id')
                ->constrained()
                ->on('man_contents')
                ->onDelete('cascade')
                ->onUpdate('cascade')
                ->index('idx_medias_content_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('man_medias', function (Blueprint $table) {
            $table->dropForeign(['content_id']);
            $table->dropColumn('content_id');
        });
    }
};
