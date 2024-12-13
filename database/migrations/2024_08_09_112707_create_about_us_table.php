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
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('key_point_1_title');
            $table->string('key_point_1_description');
            $table->string('key_point_2_title');
            $table->string('key_point_2_description');
            $table->string('key_point_3_title');
            $table->string('key_point_3_description');
            $table->string('key_point_4_title');
            $table->string('key_point_4_description');
            $table->boolean('is_active')->default(1)->comment('0- inactive, 1- active');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};
