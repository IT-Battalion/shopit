<?php

namespace Database\Seeders;

use App\Models\Icon;
use Database\Factories\ProductCategoryFactory;
use Illuminate\Database\Seeder;

class IconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Icon::factory()
            ->count(count(ProductCategoryFactory::categories))
            ->create();
    }
}
