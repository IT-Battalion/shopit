<?php

use App\Enums\AttributeType;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\Products\ProductService;

test('create product', function () {
    $service = $this->app->make(ProductService::class);
    $product = $service->create('test', 33.33, 'The test product should be deleted soonTM', 20.00, ProductCategory::all()->random());
    expect(Product::whereName('test')->exists())->toBeTrue()->and(is_null($product))->toBeFalse();
})->actingAs(Admin::all()->random());

test('create product images', function () {
    $service = $this->app->make(ProductService::class);
    $product = $service->get('test');
    $service->addImage('/path/', 'IMG/png', $product->id);
    $service->addImage('/path/', 'IMG/png', $product->id);
    $service->addImage('/testpath/', 'IMG/png', $product->id);
    expect($product->images_count)->toBeGreaterThan(0);
})->actingAs(Admin::all()->random());

test('set thumbnail image', function () {
    $service = $this->app->make(ProductService::class);
    $product = $service->get('test');
    $img = $service->getImage($product->images->first()->id);
    $p = $service->setThumbnail($img, $product->name);
    expect(is_null($p->thumbnail))->toBeFalse();
});

test('create product attributes', function () {
    $service = $this->app->make(ProductService::class);
    $service->addAttribute(AttributeType::COLOR, json_encode([
        'Blau:#0000ff',
        'Rot:#ff0000',
        'Grün:#00ff00',
    ]), 'test');
    $attributeType = $service->hasAttributeType(AttributeType::COLOR, 'test');
    $attribute = $service->hasAttribute('Rot:#ff0000', 'test');
    expect($attribute)->toBeTrue()->and($attributeType)->toBeTrue();
})->actingAs(Admin::all()->random());

test('delete product', function () {
    $service = $this->app->make(ProductService::class);
    $service->delete('test');
    $product = $service->get('test');
    expect($product)->toBeNull();
});
