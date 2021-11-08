<?php

namespace App\Services\Products;

use App\Exceptions\ProductNotFoundException;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Auth;

class ProductService implements ProductServiceInterface
{

    function create(string $name, float $price, string $description, float $tax, ProductCategory $category, int $available = -1): Product
    {
        return Product::create(['name' => $name, 'description' => $description, 'price' => $price, 'tax' => $tax, 'product_category_id' => $category->id, 'available' => $available, 'created_by' => Auth::user()->id, 'updated_by' => Auth::user()->id]);
    }

    function delete(string $name = null, int $id = null): void
    {
        $product = $this->get($name, $id);
        if (!is_null($product)) {
            $product->delete();
        } else {
            throw new ProductNotFoundException(__('exceptionMessages.product_not_found_for_deletion'));
        }
    }

    function get(string $name = null, int $id = null): Product|null
    {
        if (!is_null($name)) return Product::whereName($name)->get()->first();
        if (!is_null($id)) return Product::whereId($id)->get()->first();
        return null;
    }

    function edit(int $id = null, string $name = null, string $newName = null, float $price = null, string $description = null, ProductImage $thumbnail = null): Product|null
    {
        if (!is_null($id)) $product = Product::whereId($id)->get()->first();
        if (!is_null($name)) $product = Product::whereName($name)->get()->first();
        if (!isset($product)) return null;

        switch (false) {
            case is_null($newName):
            {
                $product->name = $newName;
            }
            case is_null($price):
            {
                $product->price = $price;
            }
            case is_null($description):
            {
                $product->description = $description;
            }
            case is_null($thumbnail):
            {
                $product->thumbnail = $thumbnail;
            }
            default:
                $product->save();
        }
        return $product;
    }

    function addImage(string $path, string $type, int $id = null, string $name = null): ProductImage
    {
        $product = $this->get($name, $id);
        if (!is_null($product)) {
            return ProductImage::create(['path' => $path, 'type' => $type, 'created_by' => Auth::user()->id, 'updated_by' => Auth::user()->id]);
        } else {
            throw new ProductNotFoundException(__('exceptionMessages.product_not_found_for_image'));
        }
    }

    function setThumbnail(ProductImage $image, int $id = null, string $name = null): Product
    {
        $product = $this->get($name, $id);
        if (!is_null($product)) {
            $product->thumbnail = $image->id;
            $product->save();
            return $product;
        } else {
            throw new ProductNotFoundException(__('exceptionMessages.product_not_found_for_image'));
        }
    }

    function addAttribute(int $type, string $values_available, int $id = null, string $name = null): ProductAttribute
    {
        $product = $this->get($name, $id);
        if (!is_null($product)) {
            return ProductAttribute::create(['type' => $type, 'values_available' => $values_available, 'created_by' => Auth::user()->id, 'updated_by' => Auth::user()->id]);
        } else {
            throw new ProductNotFoundException(__('exceptionMessages.product_not_found_for_attribute'));
        }
    }

    function getImage(int $id = null): ProductImage
    {
        return ProductImage::whereId($id)->get()->first();
    }

    function hasAttributeType(int $type, int $id = null, string $name = null): bool
    {
        $product = $this->get($name, $id);
        if (!is_null($product)) {
            $attributes = $product->attributes();
            foreach ($attributes as $attribute) {
                if ($attribute->type === $type) return true;
            }
            return false;
        } else {
            throw new ProductNotFoundException(__('exceptionMessages.product_not_found_for_attribute'));
        }
    }

    function hasAttribute(string $value, int $id = null, string $name = null): bool
    {
        $product = $this->get($name, $id);
        if (!is_null($product)) {
            $attributes = $product->attributes();
            foreach ($attributes as $attribute) {
                if (str_contains($attribute->values_available, $value)) return true;
            }
            return false;
        } else {
            throw new ProductNotFoundException(__('exceptionMessages.product_not_found_for_attribute'));
        }
    }
}
