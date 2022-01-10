<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\ShoppingCart\ShoppingCartServiceInterface;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    public function all(Request $request, ShoppingCartServiceInterface $shoppingCartService) {
        $shoppingCartProducts = $request->user()->shopping_cart->map(function (Product $product) {
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
}
