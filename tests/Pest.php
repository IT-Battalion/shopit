<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Collection;

uses(Tests\TestCase::class)->in('Feature', 'Unit');
uses(\Illuminate\Foundation\Testing\DatabaseTransactions::class)->in('Unit');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function saturateShoppingCart(User $user): Collection
{
    $products = collect();

    for ($i = 0; $i < 2; $i++) {
        $product = Product::factory()
            ->state(['name' => "TestProduct$i", 'price' => '20', 'tax' => .20])
            ->create();
        $products->add($product);
    }

    $result = clone $products;

    $products = $products->mapWithKeys(function (Product $product) {
        return [$product->id => ['count' => 2]];
    });

    $user->shopping_cart()->attach($products);

    return $result;
}
