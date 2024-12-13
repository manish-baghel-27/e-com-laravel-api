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
        Schema::table('products', function (Blueprint $table) {
            $table->string('meta_title')->after('id');
            $table->mediumText('meta_keywords')->after('meta_title');
            $table->mediumText('meta_desription')->after('meta_keywords');
            $table->longText('description')->nullable()->after('meta_desription');
            $table->double('selling_price')->nullable()->after('description');
            $table->double('original_price')->nullable()->after('selling_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
