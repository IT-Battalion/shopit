<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ShoppingCartController extends Controller
{
    public function products()
    {
        return Auth::user()->shopping_cart();
    }

    public function total()
    {
        return $this->products()->get()->reduce(function ($carry, $product) {
            return $carry + $product->pivot->count * $product->price;
        }, 0);
    }

    public function index()
    {
        return view('shopping-cart', [
            'products' => $this->products()->get(),
            'total' => $this->total(),
        ]);
    }

    public function remove($product_id)
    {
        return $this->products()->detach($product_id);
    }

    public function add(Request $request, $product_id): void
    {
        $this->products()->attach($product_id, [
            'count' => $request->count,
        ]);
    }

    public function has($product_id)
    {
        return Auth::user()->shopping_cart->has($product_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        if ($this->has($id))
        {
            if ($this->remove($id))
            {
                return response()->json(['success' => true]);
            }
            return response()->json(['message' => 'Product could not be removed!', 'success' => false], 500);
        }
        return response()->json(['message' => 'Not Found!', 'success' => false], 404);
    }
}
