<?php

namespace App\Services\Products;

use App\Exceptions\ProductNotFoundException;
use App\Models\Product;
use App\Models\ProductImage;

class ProductService implements ProductServiceInterface
{

    function create(string $name, float $price, string $description): Product
    {
        return Product::create(['name' => $name, 'description' => $description, 'price' => $price]);
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
}
