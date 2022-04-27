<?php

use Database\Seeders\CouponCodeSeeder;
use Database\Seeders\DocumentSeeder;
use Database\Seeders\HighlightedProductSeeder;
use Database\Seeders\OrderSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ShoppingCartSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
//            IconSeeder::class,
            ProductSeeder::class,
            CouponCodeSeeder::class,
            OrderSeeder::class,
            ShoppingCartSeeder::class,
            HighlightedProductSeeder::class,
            DocumentSeeder::class
        ]);
    }
}
