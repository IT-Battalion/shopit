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
            $table->foreignUuid('created_by')->constrained('users');
            $table->foreignUuid('updated_by')->constrained('users');
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('customer')->constrained('users');
            $table->float('price', 22, 2);
            $table->foreignUuid('coupon_code_id')->constrained();
            $table->foreignUuid('authorizing_admin')->nullable()->constrained('users');
            $table->timestamp('received_at')->nullable();
            $table->foreignUuid('received_by')->nullable()->constrained('users');
            $table->timestamp('payed_at')->nullable();
            $table->foreignUuid('transaction_confirmed_by')->nullable()->constrained('users');
            $table->timestamp('handed_over_at')->nullable();
            $table->foreignUuid('handed_over_by')->nullable()->constrained('users');
            $table->timestamps();
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
        Schema::dropIfExists('order_product');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('coupon_codes');
    }
}
