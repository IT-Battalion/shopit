<?php

namespace App\Services\Products;

use App\Models\HighlightedProduct;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductClothingAttribute;
use App\Models\ProductColorAttribute;
use App\Models\ProductDimensionAttribute;
use App\Models\ProductImage;
use App\Models\ProductVolumeAttribute;
use App\Types\Money;
use Auth;
use Illuminate\Support\Collection;

class ProductService implements ProductServiceInterface
{
    public function createProduct(string $name, string $description, float $price, ProductCategory $category, float $tax = 0.0): Product
    {
        return Product::create([
            'name' => $name,
            'description' => $description,
            'price' => new Money($price),
            'tax' => $tax,
            'product_category_id' => $category->id,
        ])->createWith(Auth::user());
    }

    public function createProductImage(string $path, string $type, Product $product): ProductImage
    {
        $product_image = ProductImage::create([
            'type' => $type,
            'path' => $path,
            'product_id' => $product->id,
        ])->createWith(Auth::user());
        if ($product->thumbnail_id === null) {
            $product->thumbnail_id = $product_image->id;
            $product->update();
        }
        $product->refresh();
        return $product_image;
    }

    public function deleteProduct(Product $product): bool
    {
        $product->deleteRelated();
        return $product->delete();
    }

    public function highlightProduct(Product $product): HighlightedProduct
    {
        return HighlightedProduct::create([
            'product_id' => $product->id,
        ]);
    }

    public function createProductClothingAttribute(string $size): ProductClothingAttribute
    {
        return ProductClothingAttribute::create([
            'size' => $size,
        ]);
    }

    public function createProductColorAttribute(string $color, string $name): ProductColorAttribute
    {
        return ProductColorAttribute::create([
            'name' => $name,
            'color' => $color,
        ]);
    }

    public function createProductVolumeAttribute(float $volume): ProductVolumeAttribute
    {
        return ProductVolumeAttribute::create([
            'volume' => $volume,
        ]);
    }

    public function createProductDimensionAttribute(float $width, float $height, float $depth): ProductDimensionAttribute
    {
        return ProductDimensionAttribute::create([
            'width' => $width,
            'height' => $height,
            'depth' => $depth,
        ]);
    }

    public function createProductWithImages(string $name, string $description, float $price, ProductCategory $category, Collection $images, float $tax = 0.0): Product
    {
        $product = $this->createProduct($name, $description, $price, $category, $tax);
        foreach ($images as $image) {
            $this->createProductImage($image->path, $image->type, $product);
        }
        return $product;
    }

    public function deleteDimensionAttribute(ProductDimensionAttribute $dimensionAttribute): bool
    {
        return $dimensionAttribute->delete();
    }

    public function deleteVolumeAttribute(ProductVolumeAttribute $productVolumeAttribute): bool
    {
        return $productVolumeAttribute->delete();
    }

    public function deleteClothingAttribute(ProductClothingAttribute $productClothingAttribute): bool
    {
        return $productClothingAttribute->delete();
    }

    public function deleteColorAttribute(ProductColorAttribute $productColorAttribute): bool
    {
        return $productColorAttribute->delete();
    }

    public function unHighlightProduct(Product $product): bool
    {
        return HighlightedProduct::whereProductId($product->id)->delete();
    }
}
