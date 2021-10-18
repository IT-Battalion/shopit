<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIcons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('artist');
            $table->string('provider');
            $table->string('license');
            $table->string('mimetype');
            $table->string('path');
            $table->timestamps();
        });

        Schema::table('product_categories', function (Blueprint $table) {
           $table->foreignId('icon_id')->after('name')->constrained();
        });

        Schema::table('order_product_categories', function (Blueprint $table) {
            $table->foreignId('icon_id')->after('name')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropForeign('product_categories_icon_id_foreign');
            $table->dropColumn('icon_id');
        });

        Schema::table('order_product_categories', function (Blueprint $table) {
            $table->dropForeign('order_product_categories_icon_id_foreign');
            $table->dropColumn('icon_id');
        });

        Schema::dropIfExists('icons');
    }
}
