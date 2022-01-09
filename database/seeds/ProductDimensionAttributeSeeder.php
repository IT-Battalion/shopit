<?php

namespace Database\Seeders;

use App\Models\ProductDimensionAttribute;
use Illuminate\Database\Seeder;

class ProductDimensionAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductDimensionAttribute::factory()
            ->count(ProductSeeder::ATTRIBUTE_COUNT)
            ->create();
    }
}
