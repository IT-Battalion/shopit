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
            $table->id();
            $table->integer('discount');
            $table->boolean('enabled');
            $table->timestamp('enabled_until');
            $table->char('code', 32)->unique();
            $table->foreignId('updated_by')->constrained('users');
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer')->constrained('users');
            $table->float('price', 22);
            $table->foreignId('coupon_code_id')->nullable()->constrained();
            $table->foreignId('authorizing_admin')->nullable()->constrained('users');
            $table->timestamp('received_at')->nullable();
            $table->foreignId('received_by')->nullable()->constrained('users');
            $table->timestamp('payed_at')->nullable();
            $table->foreignId('transaction_confirmed_by')->nullable()->constrained('users');
            $table->timestamp('handed_over_at')->nullable();
            $table->foreignId('handed_over_by')->nullable()->constrained('users');
            $table->timestamps();
        });

        Schema::create('order_product_images', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('type');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            $table->timestamps();
        });

        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained();
            $table->integer('count');
            $table->string('name');
            $table->string('description');
            $table->foreignId('thumbnail')->nullable()->constrained('order_product_images');
            $table->float('price', 12);
            $table->float('tax', 12);
            $table->integer('available');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            $table->timestamps();
        });

        Schema::create('order_product_attributes', function (Blueprint $table) {
            $table->foreignid('order_product_id')->primary()->constrained();
            $table->integer('type');
            $table->text('values_chosen');
        });

        Schema::table('order_product_images', function (Blueprint $table) {
            $table->foreignId('order_product_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        if (Schema::hasTable('order_product_images') && Schema::hasColumn('order_product_images', 'order_product_id')) {
            Schema::table('order_product_images', function (Blueprint $table) {
                $table->dropForeign('order_product_images_order_product_id_foreign');
            });
        }
        Schema::dropIfExists('order_product_attributes');
        Schema::dropIfExists('order_products');
        Schema::dropIfExists('order_product_images');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('coupon_codes');
    }
}
