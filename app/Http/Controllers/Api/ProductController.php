<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\HighlightedProduct;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductClothingAttribute;
use App\Models\ProductColorAttribute;
use App\Models\ProductDimensionAttribute;
use App\Models\ProductImage;
use App\Models\ProductVolumeAttribute;
use App\Services\Products\ProductService;
use App\Services\Products\ProductServiceInterface;
use App\Types\AttributeType;
use App\Types\ClothingSize;
use App\Types\Liter;
use App\Types\Meter;
use App\Types\Money;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $products = Cache::rememberForever('products', function () {
            return ProductCategory::whereHas('products')
                ->with('products')
                ->get()
                ->mapWithKeys(function (ProductCategory $category) {
                    return [
                        $category->name => $category->products->map(fn(Product $product) => $product->jsonPreview()),
                    ];
                });
        }
        );

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
        $values = $data['attributes'];
        $attributes = [
            'clothing' => array_map(fn($clothing) => ['size' => ClothingSize::from($clothing['size'])], $values[strval(AttributeType::CLOTHING->value)]),
            'volumes' => array_map(fn($volume) => ['volume' => new Liter($volume['volume']['value'],$volume['volume']['unit'])], $values[strval(AttributeType::VOLUME->value)]),
            'dimensions' => array_map(fn($dimension) => [
                'width' => new Meter($dimension['width']['value'], $dimension['width']['unit']),
                'height' => new Meter($dimension['height']['value'], $dimension['height']['unit']),
                'depth' => new Meter($dimension['depth']['value'], $dimension['depth']['unit']),
            ], $values[strval(AttributeType::DIMENSION->value)]),
            'colors' => $values[strval(AttributeType::COLOR->value)],
        ];
        $data = array_merge($data, ['attributes' => $attributes]);

        $product = Product::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => new Money($data['price']),
            'product_category_id' => $data['category']['id'],
        ])->createWith(Auth::user());
        $product->save();

        $thumbnail = null;
        foreach ($data['images'] as $image) {
            $tmpPath = Crypt::decryptString($image);
            $newPath = config('shop.image.permanentPath') . DIRECTORY_SEPARATOR . auth()->id() . DIRECTORY_SEPARATOR . basename($tmpPath);

            Storage::disk(config('shop.image.disk',config('filesystems.default')))->move($tmpPath, $newPath);

            $product_image = ProductImage::create([
                    'path' => $newPath,
                    'type' => 'image/jpg',
                    'product_id' => $product->id,
                ])->createWith(Auth::user());
            $product_image->save();
            $thumbnail = $thumbnail ?? $product_image;
        }
        $product->thumbnail_id = $thumbnail->id;
        $product->save();

        $colorValues = $attributes['colors'];
        foreach ($colorValues as $val) {
            $col = substr($val['color'], 1);
            $attribute = ProductColorAttribute::create([
                'color' => $col,
                'name' => $val['name'],
            ]);
            $product->productColorAttributes()->attach($attribute);
        }
        $clothingValues = $attributes['clothing'];
        foreach ($clothingValues as $val) {
            $attribute = ProductClothingAttribute::create($val);
            $product->productClothingAttributes()->attach($attribute);
        }
        $dimensionValues = $attributes['dimensions'];
        foreach ($dimensionValues as $val) {
            $attribute = ProductDimensionAttribute::create($val);
            $product->productDimensionAttributes()->attach($attribute);
        }
        $volumeValues = $attributes['volumes'];
        foreach ($volumeValues as $val) {
            $attribute = ProductVolumeAttribute::create($val);
            $product->productVolumeAttributes()->attach($attribute);
        }
        $product = $product->refresh();

        if ($data['highlighted']) {
            HighlightedProduct::create(['product_id' => $product->id]);
        }

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
        return response()->json($product);
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function showAdmin(Product $product, ProductServiceInterface $productService): JsonResponse
    {
        $result = $product->jsonSerialize();
        $result['images'] = $productService->getFilePondImages($product);
        return response()->json($result);
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
        $values = $data['attributes'];
        $attributes = [
            'clothing' => array_map(fn($clothing) => ['size' => ClothingSize::from($clothing['size'])], $values[strval(AttributeType::CLOTHING->value)]),
            'volumes' => array_map(fn($volume) => ['volume' => new Liter($volume['volume']['value'],$volume['volume']['unit'])], $values[strval(AttributeType::VOLUME->value)]),
            'dimensions' => array_map(fn($dimension) => [
                'width' => new Meter($dimension['width']['value'], $dimension['width']['unit']),
                'height' => new Meter($dimension['height']['value'], $dimension['height']['unit']),
                'depth' => new Meter($dimension['depth']['value'], $dimension['depth']['unit']),
            ], $values[strval(AttributeType::DIMENSION->value)]),
            'colors' => $values[strval(AttributeType::COLOR->value)],
        ];
        $data = array_merge($data, ['attributes' => $attributes]);
        $product->update($data);
        return response()->json($product->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response('', 204);
    }

    public function getFilePondIds(Product $product, ProductService $productService) {
        return response()->json($productService->getFilePondImages($product));
    }
}
