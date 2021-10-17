<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('order_product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('product_category_id')->constrained();
        });

        Schema::table('order_products', function (Blueprint $table) {
            $table->foreignId('order_product_category_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_product_category_id_foreign');
            $table->dropColumn('product_category_id');
        });

        Schema::table('order_products', function (Blueprint $table) {
            $table->dropForeign('order_products_order_product_category_id_foreign');
            $table->dropColumn('order_product_category_id');
        });

        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('order_product_categories');
    }
}
