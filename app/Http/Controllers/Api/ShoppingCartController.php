<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToShoppingCartRequest;
use App\Models\Product;
use App\Models\ShoppingCartEntry;
use App\Services\ShoppingCart\ShoppingCartServiceInterface;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    public function all(Request $request, ShoppingCartServiceInterface $shoppingCartService) {
        $user = $request->user();
        $shoppingCart = $user->shopping_cart;
        $shoppingCartProducts = $shoppingCart
            ->map(function (Product $product) {
                return [
                    'product' => $product,
                    'count' => $product->pivot->count,
                    'selected_attributes' => $product->pivot->productAttributes,
                ];
            });

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
