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
use App\Services\Attributes\AttributeServiceInterface;
use App\Services\ShoppingCart\ShoppingCartServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShoppingCartController extends Controller
{
    public function __construct(
        private ShoppingCartServiceInterface $shoppingCart,
        private AttributeServiceInterface $attributeService)
    {
    }

    public function all(): JsonResponse
    {
        $shoppingCart = $this->shoppingCart->getShoppingCart();

        return response()->json($shoppingCart);
    }

    public function add(AddToShoppingCartRequest $request): JsonResponse
    {
        $data = $request->validated();

        $product = Product::whereName($data['name'])->first();
        abort_if(is_null($product), 404);

        $selectedAttributes = $request->getSelectedAttributes();
        $count = $request['count'];

        $newAmount = $this->shoppingCart->addProduct($product, $selectedAttributes, $count);
        $prices = $this->shoppingCart->calculateShoppingCartPrice();
        $prices['price'] = $product->gross_price->mul($newAmount);

        $event = new ProductAddedToShoppingCartEvent(
            $product,
            $newAmount,
            $this->attributeService->getActualSelectedAttributes($selectedAttributes),
            ...$prices);
        broadcast($event)->toOthers();

        return response()->json([
            'count' => $newAmount,
            ...$prices,
        ]);
    }

    public function remove(RemoveFromShoppingCartRequest $request): JsonResponse
    {
        $data = $request->validated();

        $product = Product::whereName($data['name'])->first();
        abort_if(is_null($product), 404);

        $selectedAttributes = $request->getSelectedAttributes();
        $count = $request['count'];

        $this->shoppingCart->removeProduct($product, $selectedAttributes, $count);

        $prices = $this->shoppingCart->calculateShoppingCartPrice();

        $event = new ProductRemovedFromShoppingCartEvent(
            $product,
            $this->attributeService->getActualSelectedAttributes($selectedAttributes),
            $prices['subtotal'],
            $prices['discount'],
            $prices['tax'],
            $prices['total']);

        broadcast($event)->toOthers();

        return response()->json($prices);
    }

    public function applyCoupon(Request $request, ShoppingCartServiceInterface $shoppingCart) : JsonResponse
    {
        $data = $request->validate([
            'code' => 'required|min:6|string',
        ]);
        $couponCode = CouponCode::where('code', $data['code'])->firstOrFail();

        $user = Auth::user();
        $user->shopping_cart_coupon_id = $couponCode->id;
        $user->save();
        return response()->json($shoppingCart->calculateShoppingCartPrice());
    }

    public function resetCoupon(ShoppingCartServiceInterface $shoppingCart): JsonResponse
    {
        Auth::user()->shopping_cart_coupon_id = null;
        Auth::user()->save();
        return response()->json($shoppingCart->calculateShoppingCartPrice());
    }
}
