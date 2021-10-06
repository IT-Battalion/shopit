<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()
            ->has(User::factory()->count(200), ['isAdmin' => true])
            ->has(ProductImage::factory()->count(200))
            ->count(200)->create();
    }
}
