<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHighlightedProductRequest;
use App\Http\Requests\UpdateHighlightedProductRequest;
use App\Models\HighlightedProduct;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\JsonResponse;

class HighlightedProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $products = HighlightedProduct::all()
            ->map(fn (HighlightedProduct $product) => $product->product)
            ->map(function (Product $product) {
                $thumbnail = $product->thumbnail ?? $product->images->first();

                return [
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'imgSrc' => route('product-image', [ 'id' => $thumbnail->id ]),
                    'attributes' => $product->productAttributes
                        ->map(function (ProductAttribute $attribute) {
                            return [
                                'type' => $attribute->type,
                                'values_available' => $attribute->values_available,
                            ];
                        }),
                    'amount' => $product->available,
                ];
            });

        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreHighlightedProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHighlightedProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HighlightedProduct  $highlightedProduct
     * @return \Illuminate\Http\Response
     */
    public function show(HighlightedProduct $highlightedProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHighlightedProductRequest  $request
     * @param  \App\Models\HighlightedProduct  $highlightedProduct
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHighlightedProductRequest $request, HighlightedProduct $highlightedProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HighlightedProduct  $highlightedProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(HighlightedProduct $highlightedProduct)
    {
        //
    }
}
