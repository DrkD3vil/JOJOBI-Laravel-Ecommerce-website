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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('categoryid')->unique();
            $table->uuid('uuid')->unique()->nullable();
            $table->string('category_name');
            $table->string('category_barcode')->unique();
            $table->timestamps();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change(); // Make UUID column non-nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
