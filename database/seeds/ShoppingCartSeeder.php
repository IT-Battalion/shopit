<?php

namespace Database\Seeders;

use App\Models\ShoppingCart;
use Illuminate\Database\Seeder;

class ShoppingCartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShoppingCart::factory()->count(ProductSeeder::PRODUCT_COUNT * 3)->create();
    }
}
