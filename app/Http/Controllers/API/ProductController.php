<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Traits\ApiResponder;

class ProductController extends Controller
{
    use ApiResponder;

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
                            'imgSrc' => route('product-image', ['id' => $thumbnail->id]),
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $nameOrId)
    {
        $product = Product::whereId($nameOrId)->first() ?? Product::whereName($nameOrId)->first();

        if (is_null($product)) {
            return $this->error(404, "Not found");
        }

        return $this->success([
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
            'attributes' => $product->productAttributes->map(function (ProductAttribute $attribute) {
                return [
                    'type' => $attribute->type,
                    'values_available' => $attribute->values_available,
                ];
            }),
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
