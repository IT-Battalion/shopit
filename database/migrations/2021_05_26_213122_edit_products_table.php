<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('attribute_value');
            $table->string('attribute_type');
            $table->string('attribute_unit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $columns = [
                'attribute_value',
                'attribute_type',
                'attribute_unit',
            ];

            foreach ($columns as $column)
            {
                $table->dropColumn($column);
            }
        });
    }
}
