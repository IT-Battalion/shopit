<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductClothingAttribute;
use App\Models\ProductColorAttribute;
use App\Models\ProductDimensionAttribute;
use App\Models\ProductVolumeAttribute;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public const PRODUCT_COUNT = 10;
    public const ATTRIBUTE_COUNT = self::PRODUCT_COUNT/3;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ProductCategorySeeder::class,
            ProductClothingAttributeSeeder::class,
            ProductDimensionAttributeSeeder::class,
            ProductVolumeAttributeSeeder::class,
            ProductColorAttributeSeeder::class,
        ]);

        $products = Product::factory()
            ->count(self::PRODUCT_COUNT)
            ->create();

        $products->each(function (Product $product) {
            $clothingAttributes = ProductClothingAttribute::inRandomOrder()->limit(mt_rand(0, self::ATTRIBUTE_COUNT))->get();
            $dimensionAttributes = ProductDimensionAttribute::inRandomOrder()->limit(mt_rand(0, self::ATTRIBUTE_COUNT))->get();
            $volumeAttributes = ProductVolumeAttribute::inRandomOrder()->limit(mt_rand(0, self::ATTRIBUTE_COUNT))->get();
            $colorAttributes = ProductColorAttribute::inRandomOrder()->limit(mt_rand(0, self::ATTRIBUTE_COUNT))->get();

            $clothingAttributes->each(function (ProductClothingAttribute $clothingAttribute) use ($product) {
                $product->productClothingAttributes()->attach($clothingAttribute);
            });
            $dimensionAttributes->each(function (ProductDimensionAttribute $dimensionAttribute) use ($product) {
                $product->productDimensionAttributes()->attach($dimensionAttribute);
            });
            $volumeAttributes->each(function (ProductVolumeAttribute $volumeAttribute) use ($product) {
                $product->productVolumeAttributes()->attach($volumeAttribute);
            });
            $colorAttributes->each(function (ProductColorAttribute $colorAttribute) use ($product) {
                $product->productColorAttributes()->attach($colorAttribute);
            });
        });


        $this->call([
            ProductImageSeeder::class,
        ]);
    }
}
