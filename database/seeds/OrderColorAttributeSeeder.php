<?php

namespace Database\Seeders;

use App\Models\OrderColorAttribute;
use Illuminate\Database\Seeder;

class OrderColorAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderColorAttribute::factory()
            ->count(ProductSeeder::ATTRIBUTE_COUNT)
            ->create();
    }
}
