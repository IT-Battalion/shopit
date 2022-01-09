<?php

namespace Database\Seeders;

use App\Models\OrderDimensionAttribute;
use Illuminate\Database\Seeder;

class OrderDimensionAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderDimensionAttribute::factory()
            ->count(ProductSeeder::ATTRIBUTE_COUNT)
            ->create();
    }
}
