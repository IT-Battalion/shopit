<?php

use App\Enums\AttributeType;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\Products\ProductService;

test('create product', function () {
    $this->actingAs(Admin::all()->random());
    $service = $this->app->make(ProductService::class);
    //wie haben ein problem. Man kann bei unit tests nicht acting as machen :( das geht bei artian commands und requests aber man kann keine methoden callen
    $product = $service->create('test', 33.33, 'The test product should be deleted soonTM', 20.00, ProductCategory::all()->random());
    expect(Product::whereName('test')->exists())->toBeTrue()->and(is_null($product))->toBeFalse();
});

test('create product images', function () {
    $this->actingAs(Admin::all()->random());
    $service = $this->app->make(ProductService::class);
    $product = $service->get('test');
    $service->addImage('/path/', 'IMG/png', $product->id);
    $service->addImage('/path2/', 'IMG/png', $product->id);
    $service->addImage('/testpath/', 'IMG/png', $product->id);
    expect($product->images()->count())->toBeGreaterThan(0);
});

test('create product attributes', function () {
    $service = $this->app->make(ProductService::class);
    $service->addAttribute(AttributeType::COLOR, json_encode([
        'Blau:#0000ff',
        'Rot:#ff0000',
        'Grün:#00ff00',
    ]), null, 'test');
    $service->addAttribute(AttributeType::COLOR, json_encode([
        'White:#ffffff',
    ]), null, 'test');
    $attributeType = $service->hasAttributeType(AttributeType::COLOR, null, 'test');
    $attribute = $service->hasAttribute('Rot:#ff0000', null, 'test');
    expect($attributeType)->toBeTrue()
        ->and($attribute)->toBeTrue();
});

test('set thumbnail image', function () {
    $this->actingAs(Admin::all()->random());
    $service = $this->app->make(ProductService::class);
    $product = $service->get('test');
    $img = $service->getImage($product->images->first()->id);
    $p = $service->setThumbnail($img, null, $product->name);
    expect(is_null($p->thumbnail))->toBeFalse();
});

test('edit Product', function () {
    $this->actingAs(Admin::all()->random());
    $service = $this->app->make(ProductService::class);
    $service->edit(null, 'test', null, null, 'Edited Description');
    expect($service->get('test')->description)->toEqual('Edited Description');
});

test('edit Product Image', function () {
    $service = $this->app->make(ProductService::class);
    $product = $service->get('test');
    $image = $product->images()->first();
    $service->editImage($image, 'editedPathXYZ');
    expect($image->path)->toEqual('editedPathXYZ');
});

test('edit Product Attribute', function () {
    $service = $this->app->make(ProductService::class);
    $product = $service->get('test');
    $attribute = $product->attributes()->first();
    $service->editAttribute($attribute, AttributeType::VOLUME);
    expect($attribute->type)->toEqual(AttributeType::VOLUME);
});


test('delete product attribute', function () {
    $service = $this->app->make(ProductService::class);
    $product = $service->get('test');
    $service->removeAttribute($product->attributes()->first());
    expect($product->attributes()->count())->toEqual(1);
});

test('delete product image', function () {
    $service = $this->app->make(ProductService::class);
    $product = $service->get('test');
    $service->removeImage($product->images()->first());
    expect($product->images()->count())->toEqual(2);
});

test('delete product', function () {
    $service = $this->app->make(ProductService::class);
    $service->delete('test');
    $product = $service->get('test');
    expect($product)->toBeNull();
});
