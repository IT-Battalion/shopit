<?php

namespace Database\Seeders;

use App\Models\HighlightedProduct;
use Illuminate\Database\Seeder;

class HighlightedProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HighlightedProduct::factory()->count(2)->create();
    }
}
