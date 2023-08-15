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
        Schema::create('sorts', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->unsignedBigInteger('field_id')->nullable();
            $table->unsignedBigInteger('sortable_id')->nullable()->comment('The ID of the model instance that morphs to this table');
            $table->string('sortable_type')->nullable()->comment('The namespace of the model that morphs to this table');
            $table->string('value')->nullable()->comment('The ID of the sort or order option');
            $table->string('label')->nullable()->comment('The label of the sort or order option');
            $table->boolean('is_order')->default(false)->comment('True if the field is going to be used to order the records');
            $table->boolean('is_sort')->default(false)->comment('True if the field is going to be used to sort the records');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sorts');
    }
};
