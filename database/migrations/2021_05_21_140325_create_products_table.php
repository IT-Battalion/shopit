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
            $table->id();
            $table->string('path');
            $table->string('type');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->foreignId('thumbnail')->nullable()->default(null)->constrained('product_images');
            $table->float('price', 12);
            $table->float('tax', 12);
            $table->integer('available');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            $table->timestamps();
        });

        Schema::table('product_images', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained();
        });

        Schema::create('product_attributes', function (Blueprint $table) {
            $table->foreignId('product_id')->primary()->constrained();
            $table->integer('type');
            $table->text('values_available');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        if (Schema::hasTable('product_images') && Schema::hasColumn('product_images', 'product_id')) {
            Schema::table('product_images', function (Blueprint $table) {
                $table->dropForeign('product_images_product_id_foreign');
            });
        }
        Schema::dropIfExists('product_attributes');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_images');
    }
}
