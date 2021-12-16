<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = ProductCategory::all()
            ->mapWithKeys(function (ProductCategory $category) {

                return [
                    $category->name => $category->products->map(function (Product $product) {
                        $thumbnail = $product->thumbnail ?? $product->images->first();

                        return [
                            'name' => $product->name,
                            'description' => $product->description,
                            'price' => $product->price,
                            'amount' => $product->available,
                            'imgSrc' => route('product-image', [ 'id' => $thumbnail->id ]),
                            'tax' => $product->tax,
                            'attributes' => $product->productAttributes->map(function (ProductAttribute $attribute) {
                                return [
                                    'type' => $attribute->type,
                                    'values_available' => $attribute->values_available,
                                ];
                            }),
                        ];
                    }),
                ];
            });

        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
