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
                ->mapWithKeys(function (Product $product) {
                    return [$product->id => ['count' => rand(1, 10)]];
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
