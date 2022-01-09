<?php

namespace Database\Seeders;

use App\Models\ProductClothingAttribute;
use Illuminate\Database\Seeder;

class ProductClothingAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductClothingAttribute::factory()
            ->count(ProductSeeder::ATTRIBUTE_COUNT)
            ->create();
    }
}
