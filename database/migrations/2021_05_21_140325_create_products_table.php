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

        Schema::create('product_product_image', function (Blueprint $table) {
            $table->uuid('product_id');
            $table->uuid('product_image_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('product_image_id')->references('id')->on('product_images');
            $table->primary(['product_id', 'product_image_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        if (Schema::hasTable('product_product_image'))
        {
            Schema::table('product_product_image', function (Blueprint $table) {
                $table->dropForeign('product_product_image_product_id_foreign');
                $table->dropForeign('product_product_image_product_image_id_foreign');
                $table->drop();
            });
        }

        if (Schema::hasTable('products'))
        {
            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign('products_thumbnail_foreign');
                $table->drop();
            });
        }

        Schema::dropIfExists('product_images');
    }
}
