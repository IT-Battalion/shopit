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
            $table->string('name')->unique();
            $table->string('description');
            $table->foreignId('thumbnail')->nullable()->constrained('product_images')->onDelete('set null');
            $table->float('price', 12);
            $table->float('tax', 12);
            $table->integer('available')->default(-1);
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            $table->timestamps();
        });

        Schema::table('product_images', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained('products');
        });

        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->integer('type');
            $table->json('values_available'); //Fuck you damianik
            $table->timestamps();
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
