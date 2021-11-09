<?php

namespace App\Services\Products;

use App\Exceptions\ProductNotFoundException;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Models\ProductImage;

interface ProductServiceInterface
{
    /**
     * Create a new Product for the Shop.
     * @param string $name The name of the Product
     * @param float $price The price of the Product
     * @param string $description The Description of the new Product
     * @param float $tax The Tax of the Product.
     * @param ProductCategory $category The Category for the Product
     * @param int $available The Amount of Products available. Default = -1 -> limitless
     * @return Product The created Product
     */
    function create(string $name, float $price, string $description, float $tax, ProductCategory $category, int $available = -1): Product;

    /**
     * Deletes a Product from the Shop.
     * @param string|null $name The Name of the Product you want to delete (or empty if searched by id)
     * @param int|null $id The ID of the Product you want to delete (or empty if searched by name)
     * @return void
     * @throws ProductNotFoundException if the Product you want to delete isn't found.
     */
    function delete(string $name = null, int $id = null): void;

    /**
     * Receives a Product from the Shop or null.
     * @param string|null $name The Name of the Product you want to receive. Can only be one. Or empty if searched by ID.
     * @param int|null $id The ID of the Product you want to receive. Can only be one. Or empty if searched by Name.
     * @return Product The Product searched for.
     */
    function get(string $name = null, int $id = null): Product;

    /**
     * Edits a Product with the Attributes given.
     * @param int|null $id The ID of the Product you want to edit or empty if searched by name.
     * @param string|null $name The Name of the Product you want to edit or empty if searched by ID.
     * @param string|null $newName The New Name of the Product if it should be changed or null if it should stay the same.
     * @param float|null $price The New Price of the Product if it should be changed or null if it should stay the same.
     * @param string|null $description The New Description of the Product if it should be changed or null if it should stay the same.
     * @param ProductImage|null $thumbnail The New Thumbnail of the Product if it should be changed or null if it should stay the same.
     * @return Product The edited Product.
     */
    function edit(int $id = null, string $name = null, string $newName = null, float $price = null, string $description = null, ProductImage $thumbnail = null): Product|null;

    /**
     * Add Image to a Product given.
     * @param int|null $id The ID of the Product you want to search for. Null if Name is used.
     * @param string|null $name The Name of the Product you want to search for. Null if ID is used.
     * @param string $path The Path of the Image.
     * @param string $type The Type of the Image.
     * @return ProductImage the created Image.
     */
    function addImage(string $path, string $type, int $id = null, string $name = null): ProductImage;

    /**
     * Set a Thumbnail to a Product.
     * @param int|null $id The ID of the Product you want to search for. Null if Name is used.
     * @param string|null $name The Name of the Product you want to search for. Null if ID is used.
     * @param ProductImage $image The Image for the Products new thumbnail
     * @return Product The updated Product.
     */
    function setThumbnail(ProductImage $image, int $id = null, string $name = null): Product;

    /**
     * Adds an Attribute to the Product given.
     * @param int|null $id The ID of the Product you want to search for. Null if Name is used.
     * @param string|null $name The Name of the Product you want to search for. Null if ID is used.
     * @param int $type The Type of the Attribute
     * @param string $values_available The Available Values as JSON string.
     * @return ProductAttribute The Product Attribute created.
     */
    function addAttribute(int $type, string $values_available, int $id = null, string $name = null): ProductAttribute;

    /**
     * Returns an Image from any Product with the Image ID.
     * @param int $id
     * @return ProductImage The Product image you searched for.
     */
    function getImage(int $id): ProductImage;

    /**
     * Removes a Product Image.
     * @param ProductImage $image The Image which should be deleted.
     * @return void
     */
    function removeImage(ProductImage $image): void;

    /**
     * Removes a Product Attribute.
     * @param ProductAttribute $attribute The Attribute which should be deleted.
     * @return void
     */
    function removeAttribute(ProductAttribute $attribute): void;

    /**
     * Edits an existing ProductImage and returns the new one.
     * @param ProductImage $old The old ProductImage which should be edited.
     * @param string|null $path The Path of the Image.
     * @param string|null $type The Type of the Image.
     * @return ProductImage The edited ProductImage.
     */
    function editImage(ProductImage $old, string $path = null, string $type = null): ProductImage;

    /**
     * Edits an existing ProductAttribute and returns the new one.
     * @param ProductAttribute $old The old ProductAttribute which should be edited.
     * @param int|null $type The Type of the Attribute
     * @param string|null $values_available The Available Values as JSON string.
     * @return ProductAttribute The edited ProductAttribute.
     */
    function editAttribute(ProductAttribute $old, int $type = null, string $values_available = null): ProductAttribute;
}
