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
        $this->call([
            OrderProductCategorySeeder::class,
        ]);

        OrderProduct::factory()
            ->count(rand(1, 3))->create();

        $this->call([
            OrderProductImageSeeder::class,
            OrderProductAttributeSeeder::class,
        ]);
    }
}
