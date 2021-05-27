<?php

namespace App\Http\Controllers;

use App\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function store(Request $request)
    {
        $this->validate($request, [
            'images' => 'required',
            'images.*' => 'mimes:jpg,jpeg,png,gif,webp',
        ]);

        if ($request->hasFile('images'))
        {
            $thumbnail = null;
            foreach ($request->images as $image)
            {
                $path = $image->store('images');
                $product_image = new ProductImage([
                    'path' => $path,
                    'type' => $image->getMimeType(),
                ]);
                $product_image->save();
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
            if ($product->attribute_type == 'clothing')
            {
                $product->attribute_value = join(', ', $request->size);
            } else {
                $product->attribute_value = $request->size;
            }
            $product->attribute_unit = $this->productTypeToUnit($request->size_type);
            $product->product_category_id = $request->category;

            $product->save();

            return redirect()->route('products.show', ['product' => $product->id]);
        }
    }

    public function create()
    {
        return view('product-edit', [
            'categories' => ProductCategory::all(),
        ]);
    }

    public function productTypeToUnit($product_type)
    {
        return $this->size_units[$product_type];
    }
}
