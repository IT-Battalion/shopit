<?php

namespace App\Services\Categories;

use App\Models\Icon;
use App\Models\ProductCategory;

interface CategoryServiceInterface
{
    /**
     * Create a new Product Category.
     * @param string $name The Name of the Category.
     * @param Icon $icon The Icon of the Category.
     * @return ProductCategory The Product Category Model.
     */
    function create(string $name, Icon $icon): ProductCategory;

    /**
     * Deletes an existing Product Category Model.
     * @param string|null $name The Name of the Category.
     * @param int|null $id The ID of the Category.
     */
    function delete(string $name = null, int $id = null): void;

    /**
     * Edits an existing Category with the values provided.
     * @param string|null $name The Name of the Category.
     * @param int|null $id The ID of the Category.
     * @param string|null $newName The new Name of the Category or null if not changed.
     * @param Icon|null $icon The new Icon of the Category or null if not changed.
     * @return ProductCategory The new Product Category Model with the changed values.
     */
    function edit(string $name = null, int $id = null, string $newName = null, Icon $icon = null): ProductCategory;

    /**
     * Receives an existing Product Category Model and returns it.
     * @param string|null $name The Name of the Category.
     * @param int|null $id The ID of the Category.
     * @return ProductCategory The Product Category found.
     */
    function get(string $name = null, int $id = null): ProductCategory;
}
