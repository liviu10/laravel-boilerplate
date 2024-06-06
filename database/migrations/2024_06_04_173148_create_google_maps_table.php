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
        Schema::create('google_maps', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->string('description')->nullable(false);
            $table->string('address')->nullable(false);
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('user_id')
                ->constrained()
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index(
                'user_id',
                'idx_users_google_maps_id'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_maps');
        Schema::table('google_maps', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropIndex('idx_users_google_maps_id');
        });
    }
};
