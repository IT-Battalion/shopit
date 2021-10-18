<?php

namespace Database\Seeders;

use App\Models\OrderProductCategory;
use Illuminate\Database\Seeder;

class OrderProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderProductCategory::factory()
            ->allExampleCategories()
            ->create();
    }
}
