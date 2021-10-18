<?php

namespace Database\Seeders;

use App\Models\OrderProduct;
use Database\Factories\ProductCategoryFactory;
use Illuminate\Database\Seeder;

class OrderProductSeeder extends Seeder
{
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
            OrderProductCategorySeeder::class,
        ]);

        OrderProduct::factory()
            ->state([
                "created_by" => $admin,
                "updated_by" => $admin,
                "order_product_category_id" => $category,
            ])
            ->count(rand(0, 3))->create();

        $this->call([
            OrderProductImageSeeder::class,
            OrderProductAttributeSeeder::class,
        ]);
    }
}
