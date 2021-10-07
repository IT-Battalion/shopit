<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('path');
            $table->string('type');
            $table->uuid('created_by');
            $table->uuid('updated_by');
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('description');
            $table->uuid('thumbnail');
            $table->float('price', 12, 2);
            $table->integer('sale');
            $table->integer('available');
            $table->uuid('created_by');
            $table->uuid('updated_by');
            $table->timestamps();
            $table->foreign('thumbnail')->references('id')->on('product_images');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        Schema::table('product_images', function (Blueprint $table) {
            $table->foreignUuid('product_id')->constrained('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        if (Schema::hasColumn('product_images', 'product_id')) {
            Schema::table('product_images', function (Blueprint $table) {
                $table->dropForeign('product_images_product_id_foreign');
            });
        }

        Schema::dropIfExists('products');
        Schema::dropIfExists('product_images');
    }
}
