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
            $table->decimal('discount', 2, unsigned: true);
            $table->boolean('enabled')->default(true);
            $table->timestamp('enabled_until')->nullable();
            $table->char('code', 32)->unique();
            $table->foreignId('created_by_id')->constrained('users');
            $table->foreignId('updated_by_id')->constrained('users');
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users');
            $table->foreignId('coupon_code_id')->nullable()->constrained();
            $table->timestamp('paid_at')->nullable();
            $table->foreignId('transaction_confirmed_by_id')->nullable()->constrained('users');
            $table->timestamp('products_ordered_at')->nullable(); // user order timestamp is the "created_at" column added by
                                                             // the default timestamps with `$table->timestamps()`
            $table->foreignId('products_ordered_by_id')->nullable()->constrained('users');
            $table->timestamp('products_received_at')->nullable();
            $table->foreignId('products_received_by_id')->nullable()->constrained('users');
            $table->timestamp('handed_over_at')->nullable();
            $table->foreignId('handed_over_by_id')->nullable()->constrained('users');
            $table->timestamps();
        });

        Schema::create('order_product_images', function (Blueprint $table) {
            $table->id();
            $table->text('path');
            $table->string('type');
            $table->foreignId('created_by_id')->constrained('users');
            $table->foreignId('updated_by_id')->constrained('users');
            $table->timestamps();
        });

        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained();
            $table->integer('count', unsigned: true);
            $table->string('name');
            $table->text('description');
            $table->foreignId('thumbnail_id')->nullable()->constrained('order_product_images');
            $table->decimal('price', config('shop.money.max_digits') + config('shop.money.decimal_points'), config('shop.money.decimal_points'), true);
            $table->decimal('tax', 2, 2, true);
            $table->foreignId('created_by_id')->constrained('users');
            $table->foreignId('updated_by_id')->constrained('users');
            $table->timestamps();
        });

        Schema::create('order_product_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignid('order_product_id')->constrained();
            $table->integer('type', unsigned: true);
            $table->json('values_chosen');
            $table->timestamps();
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
