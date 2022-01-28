<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHighlightedProductRequest;
use App\Models\HighlightedProduct;
use Illuminate\Http\JsonResponse;

class HighlightedProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
        $products = HighlightedProduct::with('product')->get()
            ->map(fn(HighlightedProduct $product) => $product->product->jsonPreview());

        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreHighlightedProductRequest $request
     * @return JsonResponse
     */
    public function store(StoreHighlightedProductRequest $request): JsonResponse
    {
        $data = $request->validated();
        $product = HighlightedProduct::create($data);
        $product = HighlightedProduct::find($product->id);
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param HighlightedProduct $highlightedProduct
     * @return JsonResponse
     */
    public function destroy(HighlightedProduct $highlightedProduct): JsonResponse
    {
        $highlightedProduct->delete();
    }
}
