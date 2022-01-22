<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToShoppingCartRequest;
use App\Http\Requests\RemoveFromShoppingCartRequest;
use App\Models\Product;
use App\Models\User;
use App\Services\ShoppingCart\ShoppingCartServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShoppingCartController extends Controller
{
    public function all(ShoppingCartServiceInterface $shoppingCartService) {
        $user = User::with([
            'shopping_cart.pivot.productClothingAttribute',
            'shopping_cart.pivot.productDimensionAttribute',
            'shopping_cart.pivot.productVolumeAttribute',
            'shopping_cart.pivot.productColorAttribute',
        ])->find(Auth::user()->id);
        $shoppingCart = $user->shopping_cart;
        $shoppingCartProducts = $shoppingCart
            ->map(function (Product $product) {
                return [
                    'product' => $product->jsonPreview(),
                    'count' => $product->pivot->count,
                    'price' => $product->gross_price->mul($product->pivot->count),
                    'selected_attributes' => $product->pivot->productAttributes,
                ];
            });
        stop_measure('map');

        $shoppingCart = [
            'products' => $shoppingCartProducts,
            'subtotal' => $shoppingCartService->calculatePrice(false, false, $user),
            'tax' => $shoppingCartService->calculateTax($user),
            'discount' => $shoppingCartService->calculateDiscount($user),
            'total' => $shoppingCartService->calculatePrice(user: $user),
        ];

        return response()->json($shoppingCart);
    }

    public function add(AddToShoppingCartRequest $request, ShoppingCartServiceInterface $shoppingCart) {
        $data = $request->validated();

        $product = Product::whereName($data['name'])->first();
        if ($product === null)
        {
            abort(404);
        }

        $selectedAttributes = collect($data['selected_attributes'])
            ->mapWithKeys(function ($selectedAttribute) {
                return [
                    $selectedAttribute['type'] => $selectedAttribute['id'],
                ];
            });

        $shoppingCart->addProduct($product, $selectedAttributes, $request['count']);
    }

    public function remove(RemoveFromShoppingCartRequest $request, ShoppingCartServiceInterface $shoppingCart) {
        $data = $request->validated();

        $product = Product::whereName($data['name'])->first();
        if ($product === null)
        {
            abort(404);
        }

        $selectedAttributes = $request->getSelectedAttributes();

        $shoppingCart->removeProduct($product, $selectedAttributes, $request['count']);
    }
}
