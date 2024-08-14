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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('productid')->unique();
            $table->uuid('uuid')->unique();
            $table->string('product_barcode')->unique();
            $table->string('product_name')->nullable();
            $table->longText('description')->nullable();
            $table->string('product_image')->nullable();
            $table->decimal('original_price', 8, 2)->nullable();
            $table->decimal('sell_price', 8, 2)->nullable();
            $table->decimal('discount', 5, 2)->nullable();
            $table->string('categoryid')->nullable();
            $table->string('brand')->nullable();
            $table->string('supplier')->nullable();
            $table->integer('quantity')->nullable();
            $table->boolean('is_new')->default(false);
            $table->boolean('is_on_discount')->default(false);
            $table->timestamps();

            $table->foreign('categoryid')->references('categoryid')->on('categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['categoryid']);
        });

        Schema::dropIfExists('products');
    }
};
