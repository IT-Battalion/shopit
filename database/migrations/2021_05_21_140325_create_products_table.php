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
            $table->text('path');
            $table->string('type');
            $table->foreignId('created_by_id')->constrained('users');
            $table->foreignId('updated_by_id')->constrained('users');
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description');
            $table->foreignId('thumbnail_id')->nullable()->constrained('product_images')->onDelete('set null');
            $table->float('price', 16, 8, true);
            $table->float('tax', 2, 2, true);
            $table->integer('available')->default(-1);
            $table->foreignId('created_by_id')->constrained('users');
            $table->foreignId('updated_by_id')->constrained('users');
            $table->timestamps();
        });

        Schema::table('product_images', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained('products');
        });

        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->integer('product_attribute_id', unsigned: true);
            $table->string('product_attribute_type');
            $table->timestamps();
        });

        Schema::create('product_clothing_attributes', function (Blueprint $table) {
            $table->id();
            $table->integer('size', unsigned: true); // enum clothing size
            $table->timestamps();
        });

        Schema::create('product_dimension_attributes', function (Blueprint $table) {
            $table->id();
            $table->integer('width', unsigned: true);
            $table->integer('height', unsigned: true);
            $table->integer('depth', unsigned: true);
            $table->timestamps();
        });

        Schema::create('product_volume_attributes', function (Blueprint $table) {
            $table->id();
            $table->integer('volume', unsigned: true);
            $table->timestamps();
        });

        Schema::create('product_color_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color', 6);
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
        Schema::dropIfExists('product_clothing_attributes');
        Schema::dropIfExists('product_dimension_attributes');
        Schema::dropIfExists('product_volume_attributes');
        Schema::dropIfExists('product_color_attributes');

        Schema::dropIfExists('product_attributes');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_images');
    }
}
