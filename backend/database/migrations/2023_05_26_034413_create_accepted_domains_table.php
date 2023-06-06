<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcceptedDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accepted_domains', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->string('domain', 50)->unique('domain');
            $table->string('type', 50);
            $table->foreignId('user_id')->index('idx_accepted_domains_user_id')->comment('The id of the user who added this record');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accepted_domains');
    }
}
