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
    public function up()
    {
        Schema::create('shopping_cart', function (Blueprint $table) {
            $table->foreignUuid('user_id')->constrained();
            $table->foreignUuid('product_id')->constrained();
            $table->integer('count');
            $table->timestamps();
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('shopping_cart'))
        {
            Schema::table('shopping_cart', function (Blueprint $table) {
                $table->dropForeign('shopping_cart_product_id_foreign');
                $table->dropForeign('shopping_cart_user_id_foreign');
                $table->drop();
            });
        }
    }
}
