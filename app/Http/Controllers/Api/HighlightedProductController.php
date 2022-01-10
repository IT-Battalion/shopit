<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHighlightedProductRequest;
use App\Http\Requests\UpdateHighlightedProductRequest;
use App\Models\HighlightedProduct;
use Illuminate\Http\JsonResponse;

class HighlightedProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function all()
    {
        $products = HighlightedProduct::all()
            ->map(fn (HighlightedProduct $product) => $product->product);

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
