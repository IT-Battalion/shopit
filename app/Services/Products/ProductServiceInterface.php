<?php

namespace App\Services\Products;

use App\Exceptions\ProductNotFoundException;
use App\Models\Product;
use App\Models\ProductImage;

interface ProductServiceInterface
{
    /**
     * Create a new Product for the Shop.
     * @param string $name The name of the Product
     * @param float $price The price of the Product
     * @param string $description The Description of the new Product
     * @return Product The created Product
     */
    function create(string $name, float $price, string $description): Product;

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
     * @param int|null $id The ID of the Product you want to edit or empty if searched by name.
     * @param string|null $name The Name of the Product you want to edit or empty if searched by ID.
     * @param string|null $newName The New Name of the Product if it should be changed or null if it should stay the same.
     * @param float|null $price The New Price of the Product if it should be changed or null if it should stay the same.
     * @param string|null $description The New Description of the Product if it should be changed or null if it should stay the same.
     * @param ProductImage|null $thumbnail The New Thumbnail of the Product if it should be changed or null if it should stay the same.
     * @return Product|null The edited Product or Null if nothing was found.
     */
    function edit(int $id = null, string $name = null, string $newName = null, float $price = null, string $description = null, ProductImage $thumbnail = null): Product|null;
}
