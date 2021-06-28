<?php

namespace App\Http\Controllers;

use App\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProductsController extends Controller
{
    protected $size_units = [
        'clothing' => '',
        'volume' => 'L',
        'weight' => 'kg',
    ];

    public function show($product_id)
    {
        $product = Product::find($product_id);
        return view('product', [
            'product' => $product,
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'images' => 'required',
            'images.*' => 'mimes:jpg,jpeg,png,gif,webp',
        ]);

        if ($request->hasFile('images'))
        {
            $product_images = [];
            $thumbnail = null;
            foreach ($request->images as $image)
            {
                $path = $image->store('images');
                $product_image = new ProductImage([
                    'path' => $path,
                    'type' => $image->getMimeType(),
                ]);
                $product_image->save();
                $product_images[] = $product_image->id;
                $thumbnail = $product_image;
            }

            $product = new Product([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'sale' => $request->sale,
                'available' => $request->available,
                'thumbnail' => $thumbnail->id,
            ]);

            $product->attribute_type = $request->size_type;
            if ($product->attribute_type === 'clothing')
            {
                $product->attribute_value = join(', ', $request->size);
            } else {
                $product->attribute_value = $request->size;
            }
            $product->attribute_unit = $this->productTypeToUnit($request->size_type);
            $product->product_category_id = $request->category;

            $product->save();

            $product->images()->attach($product_images);

            if (!$request->expectsJson())
                return redirect()->route('products.show', ['product' => $product->id]);
        }
    }

    public function create()
    {
        return view('product-edit', [
            'categories' => ProductCategory::all(),
        ]);
    }

    public function edit()
    {
        return view('product-edit', [
            'categories' => ProductCategory::all(),
        ]);
    }

    /**
     * @throws \Exception
     */
    public function destroy(Product $product): void
    {
        foreach ($product->images as $image)
        {
            Storage::delete(ProductImage::find($image->id)->path);
            $image->delete();
        }
        $product->delete();
    }

    public function productTypeToUnit($product_type): string
    {
        return $this->size_units[$product_type];
    }
}
