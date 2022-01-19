<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToShoppingCartRequest;
use App\Models\Product;
use App\Services\ShoppingCart\ShoppingCartServiceInterface;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    public function all(Request $request, ShoppingCartServiceInterface $shoppingCartService) {
        start_measure('user', 'load user');
        $user = $request->user();
        stop_measure('user');
        start_measure('shopping_cart', 'load the shopping cart');
        $shoppingCart = $user->shopping_cart;
        stop_measure('shopping_cart');
        start_measure('map_product', 'map the shopping cart products');
        $shoppingCartProducts = $shoppingCart
            ->map(function (Product $product) {
                return [
                    'product' => $product,
                    'count' => $product->pivot->count,
                    'selected_attributes' => $product->pivot->productAttributes,
                ];
            });
        stop_measure('map_product');

        $shoppingCart = [
            'products' => $shoppingCartProducts,
            'subtotal' => $shoppingCartService->calculatePrice(false, false),
            'tax' => $shoppingCartService->calculateTax(),
            'discount' => $shoppingCartService->calculateDiscount(),
            'total' => $shoppingCartService->calculatePrice(),
        ];

        return response()->json($shoppingCart);
    }

    public function add(AddToShoppingCartRequest $request) {
        dd($request->validated());
    }
}
