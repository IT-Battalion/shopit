<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppingCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('shopping_cart', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignid('product_id')->constrained();
            $table->integer('count');
            $table->foreignId('product_clothing_attribute_id')->nullable()->constrained();
            $table->foreignId('product_dimension_attribute_id')->nullable()->constrained();
            $table->foreignId('product_volume_attribute_id')->nullable()->constrained();
            $table->foreignId('product_color_attribute_id')->nullable()->constrained();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('shopping_cart_coupon_id')->nullable()->constrained('coupon_codes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('shopping_cart');

        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('shopping_cart_coupon_id');
        });
    }
}
