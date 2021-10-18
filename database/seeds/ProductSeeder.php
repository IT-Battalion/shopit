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
        $admin = rand(0, UserSeeder::adminCount);
        $category = rand(0, count(ProductCategoryFactory::categories));

        $this->call([
            ProductCategorySeeder::class,
            ]);

        Product::factory()
            ->state([
                "created_by" => $admin,
                "updated_by" => $admin,
                "product_category_id" => $category,
            ])
            ->count(self::PRODUCT_COUNT)->create();

        $this->call([
            ProductImageSeeder::class,
            ProductAttributeSeeder::class,
        ]);
    }
}
