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
     * @return Product|null The Product searched for. Can also be null if none was found.
     */
    function get(string $name = null, int $id = null): Product|null;

    /**
     * Edits a Product with the Attributes given.
     * @param int|null $id The ID of the Product you want to edit or empty if searched by name.
     * @param string|null $name The Name of the Product you want to edit or empty if searched by ID.
     * @param string|null $newName The New Name of the Product if it should be changed or null if it should stay the same.
     * @param float|null $price The New Price of the Product if it should be changed or null if it should stay the same.
     * @param string|null $description The New Description of the Product if it should be changed or null if it should stay the same.
     * @param ProductImage|null $thumbnail The New Thumbnail of the Product if it should be changed or null if it should stay the same.
     * @return Product|null The edited Product or Null if nothing was found.
     */
    function edit(int $id = null, string $name = null, string $newName = null, float $price = null, string $description = null, ProductImage $thumbnail = null): Product|null;

    /**
     * Add Image to a Product given.
     * @param int|null $id The ID of the Product you want to search for. Null if Name is used.
     * @param string|null $name The Name of the Product you want to search for. Null if ID is used.
     * @param string $path The Path of the Image.
     * @param string $type The Type of the Image.
     * @return ProductImage the created Image.
     * @throws ProductNotFoundException if the Product you want to add an Image to isn't found.
     */
    function addImage(string $path, string $type, int $id = null, string $name = null) : ProductImage;

    /**
     * Set a Thumbnail to a Product.
     * @param int|null $id The ID of the Product you want to search for. Null if Name is used.
     * @param string|null $name The Name of the Product you want to search for. Null if ID is used.
     * @param ProductImage $image The Image for the Products new thumbnail
     * @return Product The updated Product.
     * @throws ProductNotFoundException if the Product you want to set the Thumbnail for isn't found.
     */
    function setThumbnail(ProductImage $image, int $id = null, string $name = null): Product;

    /**
     * Adds an Attribute to the Product given.
     * @param int|null $id The ID of the Product you want to search for. Null if Name is used.
     * @param string|null $name The Name of the Product you want to search for. Null if ID is used.
     * @param int $type The Type of the Attribute
     * @param string $values_available The Available Values as JSON string.
     * @return ProductAttribute The Product Attribute created.
     * @throws ProductNotFoundException if the Product you want to add Attributes to isn't found.
     */
    function addAttribute(int $type, string $values_available, int $id = null, string $name = null): ProductAttribute;

    /**
     * Returns an Image from any Product with the Image ID.
     * @param int $id
     * @return ProductImage The Product image you searched for.
     */
    function getImage(int $id): ProductImage;

    /**
     * Checks if the given Product has the given Attribute Type.
     * @param int|null $id The ID of the Product you want to search for. Null if Name is used.
     * @param string|null $name The Name of the Product you want to search for. Null if ID is used.
     * @param int $type The AttributeType you want to search for.
     * @return bool true if the Attribute exists.
     * @throws ProductNotFoundException
     */
    function hasAttributeType(int $type, int $id = null, string $name = null): bool;

    /**
     * @param int|null $id The ID of the Product you want to search for. Null if Name is used.
     * @param string|null $name The Name of the Product you want to search for. Null if ID is used.
     * @param string $value Only one value you want to search for.
     * @return bool true if the Attribute exists.
     * @throws ProductNotFoundException
     */
    function hasAttribute(string $value, int $id = null, string $name = null): bool;
}
