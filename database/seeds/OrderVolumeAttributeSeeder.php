<?php

namespace Database\Seeders;

use App\Models\OrderVolumeAttribute;
use Illuminate\Database\Seeder;

class OrderVolumeAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderVolumeAttribute::factory()
            ->count(ProductSeeder::ATTRIBUTE_COUNT)
            ->create();
    }
}
