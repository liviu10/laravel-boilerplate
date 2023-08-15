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
        Schema::create('fields', function (Blueprint $table) {
            $table->id()->index('idx_id');
            $table->unsignedBigInteger('fieldable_id')->nullable()->comment('The ID of the model instance that morphs to this table');
            $table->string('fieldable_type')->nullable()->comment('The namespace of the model that morphs to this table');
            $table->string('key')->nullable()->comment('The field key (eg: field_a)');
            $table->string('type')->nullable()->comment('The field type (eg: text, email, tel, etc.)');
            $table->boolean('is_field')->default(false)->comment('True if the field is going to be used to create new records');
            $table->boolean('is_filter')->default(false)->comment('True if the field is going to be used to filter the records');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};
