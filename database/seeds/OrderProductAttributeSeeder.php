<?php

namespace Database\Seeders;

use App\Models\OrderProductAttribute;
use Illuminate\Database\Seeder;

class OrderProductAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderProductAttribute::factory()
            ->count(ProductSeeder::PRODUCT_COUNT * 4)
            ->create();
    }
}
