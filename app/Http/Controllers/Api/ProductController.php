<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = ProductCategory::whereHas('products')->get()
            ->mapWithKeys(function (ProductCategory $category) {
                return [
                    $category->name => $category->products->map(function (Product $product) {
                        $thumbnail = $product->thumbnail ?? $product->images->first();

                        return [
                            'name' => $product->name,
//                            'description' => $product->description,
                            'price' => $product->price,
                            'amount' => $product->available,
                            'thumbnail' => [
                                'id' => $product->main_thumbnail->id,
                            ],
                            'tax' => $product->tax,
                            'attributes' => $product->productAttributes,
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
     * @param string $nameOrId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $nameOrId)
    {
        $product = Product::whereId($nameOrId)->first() ?? Product::whereName($nameOrId)->first();

        abort_if(is_null($product), 404);

        return response()->json([
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'tax' => $product->tax,
            'available' => $product->available,
            'images' => $product->images->map(function (ProductImage $image) {
                return [
                    'id' => $image->id,
                ];
            }),
            'attributes' => $product->productAttributes,
        ]);
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
