<?php

namespace Database\Seeders;

use App\Models\ProductVolumeAttribute;
use Illuminate\Database\Seeder;

class ProductVolumeAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductVolumeAttribute::factory()
            ->count(ProductSeeder::ATTRIBUTE_COUNT)
            ->create();
    }
}
