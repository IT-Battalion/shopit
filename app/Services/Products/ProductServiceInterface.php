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
use Illuminate\Support\Collection;

interface ProductServiceInterface
{
    /**
     * @param string $name The name of this Product.
     * @param string $description The Description of this Product.
     * @param float $price The price of this Product.
     * @param ProductCategory $category The category in which this Product should be created.
     * @param float $tax The tax for this product (default = 0.0)
     * @return Product The created Product Model
     */
    public function createProduct(string $name, string $description, float $price, ProductCategory $category, float $tax = 0.0): Product;

    /**
     * @param string $path The path to the Image
     * @param string $type The type of the Image
     * @param Product $product The product which owns the Image
     * @return ProductImage The Product Image Model after creating
     */
    public function createProductImage(string $path, string $type, Product $product): ProductImage;

    /**
     * @param string $size The size which should be created.
     * @return ProductClothingAttribute The created Product Attribute
     */
    public function createProductClothingAttribute(string $size): ProductClothingAttribute;

    /**
     * @param string $color The color of this Color
     * @param string $name The name of this Color
     * @return ProductColorAttribute The created Product Attribute
     */
    public function createProductColorAttribute(string $color, string $name): ProductColorAttribute;

    /**
     * @param float $volume The volume
     * @return ProductVolumeAttribute The created Product Attribute
     */
    public function createProductVolumeAttribute(float $volume): ProductVolumeAttribute;

    /**
     * @param float $width The width of this Dimension
     * @param float $height The height of this Dimension
     * @param float $depth The depth of this Dimension
     * @return ProductDimensionAttribute The created Product Attribute
     */
    public function createProductDimensionAttribute(float $width, float $height, float $depth): ProductDimensionAttribute;

    /**
     * @param string $name The name of this Product.
     * @param string $description The Description of this Product.
     * @param float $price The price of this Product.
     * @param ProductCategory $category The category in which this Product should be created.
     * @param Collection $images The images for this Product.
     * @param float $tax The tax for this product (default = 0.0)
     * @return Product The created Product
     */
    public function createProductWithImages(string $name, string $description, float $price, ProductCategory $category, Collection $images, float $tax = 0.0): Product;

    /**
     * Deletes an existing Product.
     * @param Product $product The Product which should be deleted.
     * @return bool true if the Product was deleted successful - else false.
     */
    public function deleteProduct(Product $product): bool;

    /**
     * @param ProductDimensionAttribute $dimensionAttribute The Attribute which should be deleted.
     * @return bool true if the Model was successfully deleted
     */
    public function deleteDimensionAttribute(ProductDimensionAttribute $dimensionAttribute): bool;

    /**
     * @param ProductVolumeAttribute $productVolumeAttribute The Attribute which should be deleted.
     * @return bool true if the Model was successfully deleted
     */
    public function deleteVolumeAttribute(ProductVolumeAttribute $productVolumeAttribute): bool;

    /**
     * @param ProductClothingAttribute $productClothingAttribute The Attribute which should be deleted.
     * @return bool true if the Model was successfully deleted
     */
    public function deleteClothingAttribute(ProductClothingAttribute $productClothingAttribute): bool;

    /**
     * @param ProductColorAttribute $productColorAttribute The Attribute which should be deleted.
     * @return bool true if the Model was successfully deleted
     */
    public function deleteColorAttribute(ProductColorAttribute $productColorAttribute): bool;

    /**
     * Highlights an existing Product.
     * @param Product $product The Product which should be highlighted.
     * @return HighlightedProduct The Highlighted Product Model
     */
    public function highlightProduct(Product $product): HighlightedProduct;

    /**
     * Removes a highlighted Product from the highlighted Products list
     * @param Product $product The Product which should no longer be highlighted.
     * @return bool true if it was successfully removed from highlighted Products else false.
     */
    public function unHighlightProduct(Product $product): bool;
}
