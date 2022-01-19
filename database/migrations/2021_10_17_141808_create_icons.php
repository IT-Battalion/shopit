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
        /*Schema::create('icons', function (Blueprint $table) {
            $table->id();
            $table->string('original_id')->unique();
            $table->string('name');
            $table->string('artist');
            $table->string('provider');
            $table->integer('license');
            $table->string('mimetype');
            $table->string('path');
            $table->timestamps();
        });

        Schema::table('product_categories', function (Blueprint $table) {
            $table->foreignId('icon_id')->after('name')->constrained()->onDelete('cascade');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('product_categories', function (Blueprint $table) {
            $table->dropForeign('product_categories_icon_id_foreign');
            $table->dropColumn('icon_id');
        });

        Schema::dropIfExists('icons');*/
    }
}
