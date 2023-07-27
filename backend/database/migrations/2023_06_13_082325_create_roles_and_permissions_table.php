<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesAndPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_and_permissions', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->string('name')->unique();
            $table->string('description');
            $table->string('bg_color')->nullable();
            $table->string('text_color')->nullable();
            $table->string('slug');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_role_types');
    }
}
