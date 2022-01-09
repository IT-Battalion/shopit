<?php

namespace Database\Seeders;

use App\Models\CouponCode;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ShoppingCartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::inRandomOrder()->limit(rand(UserSeeder::ADMIN_COUNT, UserSeeder::NORMAL_USER_COUNT))->get();

        foreach ($users as $user) {
            $products = Product::inRandomOrder()
                ->limit(rand(1, ProductSeeder::PRODUCT_COUNT))
                ->get()
                ->mapWithKeys(callback: function (Product $product) {
                    $clothingAttribute = $product->productClothingAttributes()->inRandomOrder()->first();
                    $dimensionAttribute = $product->productDimensionAttributes()->inRandomOrder()->first();
                    $volumeAttribute = $product->productVolumeAttributes()->inRandomOrder()->first();
                    $colorAttribute = $product->productColorAttributes()->inRandomOrder()->first();

                    return [$product->id => [
                        'count' => rand(1, 10),
                        'product_clothing_attribute_id' => $clothingAttribute?->id,
                        'product_dimension_attribute_id' => $dimensionAttribute?->id,
                        'product_volume_attribute_id' => $volumeAttribute?->id,
                        'product_color_attribute_id' => $colorAttribute?->id,
                    ]];
                })
                ->toArray();

            $user->shopping_cart()->attach($products);
        }

        $usersWithCoupon = $users->random(UserSeeder::ADMIN_COUNT / 2);

        foreach ($usersWithCoupon as $user) {
            $user->shopping_cart_coupon_id = CouponCode::inRandomOrder()->first()->id;
            $user->save();
        }
    }
}
