<?php

namespace Database\Seeders;

use App\Models\OrderProductImage;
use Illuminate\Database\Seeder;

class OrderProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderProductImage::factory()
            ->count(ProductSeeder::PRODUCT_COUNT * 3)
            ->create();
    }
}
