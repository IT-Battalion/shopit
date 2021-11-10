<?php

use App\Models\Icon;
use App\Models\ProductCategory;
use App\Services\Categories\CategoryService;

test('create category', function () {
    $service = $this->app->make(CategoryService::class);
    $category = $service->create('test', Icon::all()->random());
    expect(ProductCategory::whereName($category->name)->exists())->toBeTrue();
});

test('edit category', function () {
    $service = $this->app->make(CategoryService::class);
    $category = $service->edit('test', null, 'changedTest');
    expect(ProductCategory::whereName('changedTest')->exists())->toBeTrue();
});

test('delete category', function () {
    $service = $this->app->make(CategoryService::class);
    $service->delete('changedTest');
    expect(ProductCategory::whereName('changedTest')->exists())->toBeFalse();
});
