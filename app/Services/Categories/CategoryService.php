<?php

namespace App\Services\Categories;

use App\Exceptions\CategoryNotFoundException;
use App\Models\Icon;
use App\Models\ProductCategory;

class CategoryService implements CategoryServiceInterface
{

    function create(string $name, Icon $icon): ProductCategory
    {
        return ProductCategory::create([
            'name' => $name,
            'icon_id' => $icon->id,
        ]);
    }

    function delete(string $name = null, int $id = null): void
    {
        $category = $this->get($name, $id);
        $category->delete();
    }

    function edit(string $name = null, int $id = null, string $newName = null, Icon $icon = null): ProductCategory
    {
        $category = $this->get($name, $id);
        if (isset($newName)) $category->name = $newName;
        if (isset($icon)) $category->icon_id = $icon->id;
        $category->save();
        return $category;
    }

    /**
     * @throws CategoryNotFoundException
     */
    function get(string $name = null, int $id = null): ProductCategory
    {
        if (isset($name)) $category = ProductCategory::whereName($name)->get();
        if (isset($id)) $category = ProductCategory::whereId($id)->get();
        if (!isset($category) || $category->count() === 0) throw new CategoryNotFoundException(__('exceptionMessages.category_not_found'));
        return $category->first();
    }
}
