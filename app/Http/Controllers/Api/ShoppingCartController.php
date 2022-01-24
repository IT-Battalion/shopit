<?php

namespace App\Http\Controllers\Api;

use App\Events\ProductAddedToShoppingCartEvent;
use App\Events\ProductRemovedFromShoppingCartEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddToShoppingCartRequest;
use App\Http\Requests\RemoveFromShoppingCartRequest;
use App\Models\CouponCode;
use App\Models\Product;
use App\Models\User;
use App\Services\ShoppingCart\ShoppingCartServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShoppingCartController extends Controller
{
    public function all(ShoppingCartServiceInterface $shoppingCartService)
    {
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

        $prices = $shoppingCartService->calculateShoppingCartPrice();

        $shoppingCart = [
            'products' => $shoppingCartProducts,
            ...$prices,
        ];

        return response()->json($shoppingCart);
    }

    public function add(AddToShoppingCartRequest $request, ShoppingCartServiceInterface $shoppingCart)
    {
        $data = $request->validated();

        $product = Product::whereName($data['name'])->first();
        if ($product === null) {
            abort(404);
        }

        $selectedAttributes = $request->getSelectedAttributes();

        $count = $request['count'];

        $newAmount = $shoppingCart->addProduct($product, $selectedAttributes, $count);

        $prices = $shoppingCart->calculateShoppingCartPrice();
        $prices['price'] = $product->gross_price->mul($newAmount);

        broadcast(
            new ProductAddedToShoppingCartEvent($product, $count, $selectedAttributes, $prices['subtotal'], $prices['discount'], $prices['tax'], $prices['total'])
        )->toOthers();

        return response()->json($prices);
    }

    public function remove(RemoveFromShoppingCartRequest $request, ShoppingCartServiceInterface $shoppingCart)
    {
        $data = $request->validated();

        $product = Product::whereName($data['name'])->first();
        if ($product === null) {
            abort(404);
        }

        $selectedAttributes = $request->getSelectedAttributes();
        $count = $request['count'];

        $shoppingCart->removeProduct($product, $selectedAttributes, $count);

        $prices = $shoppingCart->calculateShoppingCartPrice();

        broadcast(new ProductRemovedFromShoppingCartEvent($product, $selectedAttributes, $prices['subtotal'], $prices['discount'], $prices['tax'], $prices['total']));

        return response()->json($prices);
    }

    public function applyCoupon(Request $request, ShoppingCartServiceInterface $shoppingCart) {
        $data = $request->validate([
            'code' => 'required|min:6|string',
        ]);
        $couponCode = CouponCode::where('code', $data['code'])->firstOrFail();

        Auth::user()->shopping_cart_coupon_id = $couponCode->id;
        return response()->json($shoppingCart->calculateShoppingCartPrice());
    }

    public function resetCoupon(ShoppingCartServiceInterface $shoppingCart) {
        Auth::user()->shopping_cart_coupon_id = null;
        return response()->json($shoppingCart->calculateShoppingCartPrice());
    }
}
