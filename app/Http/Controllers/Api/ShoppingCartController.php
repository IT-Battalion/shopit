<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use App\Services\ShoppingCart\ShoppingCartServiceInterface;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    public function all(Request $request, ShoppingCartServiceInterface $shoppingCartService) {
        $shoppingCartProducts = $request->user()->shopping_cart->map(function (Product $product) {
            return [
                'count' => $product->pivot->count,
                'name' => $product->name,
                'thumbnail_id' => $product->id,
                'price' => $product->price,
                'tax' => $product->tax,
                'images' => $product->images->map(function (ProductImage $image) {
                    return [
                        'id' => $image->id,
                    ];
                }),
                'attributes' => $product->productAttributes->map(function (ProductAttribute $attribute) use ($product) {
                    return [
                        'type' => $attribute->type,
                        'values_chosen' => json_decode($product->pivot->values_chosen),
                    ];
                }),
            ];
        });

        $shoppingCart = [
            'products' => $shoppingCartProducts,
            'total' => $shoppingCartService->calculatePrice(),
        ];

        return response()->json($shoppingCart);
    }
}
