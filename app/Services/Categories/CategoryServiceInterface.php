<?php

namespace App\Services\Categories;

use App\Models\ProductCategory;

interface CategoryServiceInterface
{
    function create(): ProductCategory;
    function delete(): void;
    function edit(): ProductCategory;
    function get(): ProductCategory;
}
