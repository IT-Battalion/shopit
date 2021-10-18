<?php

namespace Database\Seeders;

use App\Models\Product;
use Database\Factories\ProductCategoryFactory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public const PRODUCT_COUNT = 10;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ProductCategorySeeder::class,
            ]);

        Product::factory()
            ->count(self::PRODUCT_COUNT)->create();

        $this->call([
            ProductImageSeeder::class,
            ProductAttributeSeeder::class,
        ]);
    }
}
