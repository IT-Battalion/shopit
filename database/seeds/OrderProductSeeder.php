<?php

namespace Database\Seeders;

use App\Models\OrderClothingAttribute;
use App\Models\OrderColorAttribute;
use App\Models\OrderDimensionAttribute;
use App\Models\OrderProduct;
use App\Models\OrderProductImage;
use App\Models\OrderVolumeAttribute;
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
            OrderClothingAttributeSeeder::class,
            OrderDimensionAttributeSeeder::class,
            OrderVolumeAttributeSeeder::class,
            OrderColorAttributeSeeder::class,
        ]);

        $products = OrderProduct::factory()
            ->count(ProductSeeder::PRODUCT_COUNT * 6)
            ->create();

        $this->call([
            OrderProductImageSeeder::class,
        ]);

        foreach ($products as $product)
        {
            $image = OrderProductImage::inRandomOrder()->take(mt_rand(1, 6))->get();

            $product->images()->attach($image);
        }
    }
}
