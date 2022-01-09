<?php

namespace Database\Seeders;

use App\Models\OrderClothingAttribute;
use Illuminate\Database\Seeder;

class OrderClothingAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderClothingAttribute::factory()
            ->count(ProductSeeder::ATTRIBUTE_COUNT)
            ->create();
    }
}
