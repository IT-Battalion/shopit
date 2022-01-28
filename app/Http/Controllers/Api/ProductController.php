<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductClothingAttribute;
use App\Models\ProductColorAttribute;
use App\Models\ProductDimensionAttribute;
use App\Models\ProductImage;
use App\Models\ProductVolumeAttribute;
use App\Types\Money;
use Auth;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $products = ProductCategory::whereHas('products')
            ->with('products')
            ->get()
            ->mapWithKeys(function (ProductCategory $category) {
                return [
                    $category->name => $category->products->map(fn(Product $product) => $product->jsonPreview()),
                ];
            });

        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductRequest $request
     * @return JsonResponse
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $data = $request->validated();
        $product = Product::create([
            'name' => $data['title'],
            'description' => $data['description'],
            'price' => new Money($data['price']),
            'product_category_id' => $data['category']['id'],
        ])->createWith(Auth::user());
        /*foreach ($data['images'] as $image) {
            $product_images[] = ProductImage::create([
                    'path' => '',
                    'type' => '',
                    'product_id' => $product->id,
                ])->createWith(Auth::user());
        }
        $product->thumbnail_id = $product_images[0]->id;
        $product->update();*/
        $attributes = $request['attributes'];
        if (isset($attributes)) {
            if ($attributes['color']['enabled']) {
                $colorVal = $attributes['color']['value']['color']['colors'];
                foreach ($colorVal as $val) {
                    $col = substr($val['color'], 1);
                    $attribute = ProductColorAttribute::create([
                        'color' => $col,
                        'name' => $val['name'],
                    ]);
                }
            }
            if ($attributes['clothing']['enabled']) {
                $clothingVal = $attributes['clothing']['value']['size'];
                foreach ($clothingVal as $val) {
                    $attribute = ProductClothingAttribute::create($val);
                }
            }
            if ($attributes['dimension']['enabled']) {
                $dimensionVal = $attributes['dimension']['value'];
                $attribute = ProductDimensionAttribute::create($dimensionVal);
            }
            if ($attributes['volume']['enabled']) {
                $volumeVal = $attributes['volume']['value']['volume'];
                $attribute = ProductVolumeAttribute::create($volumeVal);
            }
        }
        $product = $product->refresh();
        return response()->json($product);
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        //$product = Product::whereId($nameOrId)->first() ?? Product::whereName($nameOrId)->first();

        //abort_if(is_null($product), 404);

        return response()->json([
            'name' => $product->name,
            'description' => $product->description,
            'thumbnail' => ['id' => $product->thumbnail_id],
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
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return JsonResponse
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $data = $request->validated();
        $product->update($data);
        $product->refresh();
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        return response()->json($product->delete());
    }
}
