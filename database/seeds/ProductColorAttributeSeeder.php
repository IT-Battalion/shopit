<?php

namespace Database\Seeders;

use App\Models\ProductColorAttribute;
use Illuminate\Database\Seeder;

class ProductColorAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductColorAttribute::factory()
            ->count(ProductSeeder::ATTRIBUTE_COUNT)
            ->create();
    }
}
