<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShoppingCartRouteTest extends TestCase
{
    /**
     * @test
     */
    public function addShoppingCartPageAccessibleTest() {
        $product = Product::factory()->create();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/shopping-cart/add/' . $product['id']);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function removeShoppingCartPageAccessibleTest() {
        $product = Product::factory()->create();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/shopping-cart/remove/' . $product['id']);
        $response->assertStatus(200);
    }
}
