<?php

namespace Database\Seeders;

use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductImage::factory()
            ->count(ProductSeeder::PRODUCT_COUNT * 3)
            ->create();
    }
}
