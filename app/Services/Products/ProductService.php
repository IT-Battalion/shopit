<?php

namespace App\Services\Products;

use App\Exceptions\ProductNotFoundException;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Models\ProductImage;

class ProductService implements ProductServiceInterface
{

    function create(string $name, float $price, string $description, float $tax, ProductCategory $category, int $available = -1): Product
    {
        return Product::create([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'tax' => $tax,
            'product_category_id' => $category->id,
            'available' => $available,
        ]);
    }

    function addImage(string $path, string $type, int $id = null, string $name = null): ProductImage
    {
        $product = $this->get($name, $id);
        return ProductImage::create([
            'path' => $path,
            'type' => $type,
            'product_id' => $product->id,
        ]);
    }

    /**
     * @throws ProductNotFoundException
     */
    function setThumbnail(ProductImage $image, int $id = null, string $name = null): Product
    {
        $product = $this->get($name, $id);
        $product->thumbnail = $image->id;
        $product->save();
        return $product;
    }

    /**
     * @throws ProductNotFoundException
     */
    function addAttribute(int $type, string $values_available, int $id = null, string $name = null): ProductAttribute
    {
        $product = $this->get($name, $id);
        return ProductAttribute::create([
            'type' => $type,
            'values_available' => $values_available,
            'product_id' => $product->id,
        ]);
    }

    /**
     * @throws ProductNotFoundException
     */
    function get(string $name = null, int $id = null): Product
    {
        $product = null;
        if (isset($name)) {
            $product = Product::whereName($name)->get();
        }
        if (isset($id)) {
            $product = Product::whereId($id)->get();
        }
        if ($product->count() === 0) throw new ProductNotFoundException(__('exceptionMessages.product_not_found'));
        return $product->first();
    }

    function getImage(int $id): ProductImage
    {
        return ProductImage::whereId($id)->get()->first();
    }

    /**
     * @throws ProductNotFoundException
     */
    function edit(int $id = null, string $name = null, string $newName = null, float $price = null, string $description = null, ProductImage $thumbnail = null): Product
    {
        $product = $this->get($name, $id);

        if (isset($newName)) $product->name = $newName;
        if (isset($price)) $product->price = $price;
        if (isset($description)) $product->description = $description;
        if (isset($thumbnail)) $this->setThumbnail($thumbnail, $id, $name);
        $product->save();
        return $product;
    }

    function editImage(ProductImage $old, string $path = null, string $type = null): ProductImage
    {
        if (isset($path)) $old->path = $path;
        if (isset($type)) $old->type = $type;
        $old->save();
        return $old;
    }

    function editAttribute(ProductAttribute $old, int $type = null, string $values_available = null): ProductAttribute
    {
        if (isset($type)) $old->type = $type;
        if (isset($values_available)) $old->values_available = $values_available;
        $old->update();
        return $old;
    }

    function removeImage(ProductImage $image): void
    {
        $image->delete();
    }

    function removeAttribute(ProductAttribute $attribute): void
    {
        $attribute->delete();
    }

    function delete(string $name = null, int $id = null): void
    {
        $product = $this->get($name, $id);
        $product->delete();
    }
}