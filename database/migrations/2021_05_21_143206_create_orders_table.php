<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('coupon_codes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('discount');
            $table->boolean('enabled');
            $table->timestamp('enabled_until');
            $table->char('code', 32)->unique();
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('owner');
            $table->float('price', 22, 2);
            $table->foreignUuid('coupon_code_id')->constrained();
            $table->uuid('authorizing_admin');
            $table->timestamp('received_at')->nullable();
            $table->uuid('received_by')->nullable();
            $table->timestamp('payed_at')->nullable();
            $table->uuid('transaction_confirmed_by')->nullable();
            $table->timestamp('handed_over_at')->nullable();
            $table->uuid('handed_over_by')->nullable();
            $table->timestamps();
            $table->foreign('owner')->references('id')->on('users');
            $table->foreign('authorizing_admin')->references('id')->on('users');
            $table->foreign('received_by')->references('id')->on('users');
            $table->foreign('transaction_confirmed_by')->references('id')->on('users');
            $table->foreign('handed_over_by')->references('id')->on('users');
        });

        Schema::create('order_product', function (Blueprint $table) {
            $table->foreignUuid('order_id')->constrained();
            $table->foreignUuid('product_id')->constrained();
            $table->integer('count');
            $table->integer('discount');
            $table->timestamps();
            $table->primary(['order_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        if (Schema::hasTable('order_product'))
        {
            Schema::table('order_product', function (Blueprint $table) {
                $table->dropForeign('order_product_order_id_foreign');
                $table->dropForeign('order_product_product_id_foreign');
                $table->drop();
            });
        }

        if (Schema::hasTable('orders'))
        {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropForeign('orders_owner_foreign');
                $table->dropForeign('orders_coupon_code_id_foreign');
                $table->dropForeign('orders_authorizing_admin_foreign');
                $table->dropForeign('orders_received_by_foreign');
                $table->dropForeign('orders_transaction_confirmed_by_foreign');
                $table->dropForeign('orders_handed_over_by_foreign');
                $table->drop();
            });
        }

        Schema::dropIfExists('coupon_codes');
    }
}
