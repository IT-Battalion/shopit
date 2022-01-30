<?php

use App\Models\ProductClothingAttribute;
use App\Models\ProductColorAttribute;
use App\Models\ProductDimensionAttribute;
use App\Models\ProductVolumeAttribute;
use App\Services\Attributes\AttributeServiceInterface;
use App\Types\AttributeType;

test('map no selected attributes', function () {
    /** @var AttributeServiceInterface $service */
    $service = app()->make(AttributeServiceInterface::class);
    $selectedAttributes = collect([]);

    $result = $service->getActualSelectedAttributes($selectedAttributes);

    expect($result->all())->toEqual([]);
});

test('map some selected attributes', function () {
    /** @var AttributeServiceInterface $service */
    $service = app()->make(AttributeServiceInterface::class);

    /** @var ProductClothingAttribute $clothingAttribute */
    $clothingAttribute = ProductClothingAttribute::factory()->create();
    /** @var ProductColorAttribute $colorAttribute */
    $colorAttribute = ProductColorAttribute::factory()->create();

    $selectedAttributes = collect([
        AttributeType::CLOTHING->value => $clothingAttribute->id,
        AttributeType::COLOR->value => $colorAttribute->id,
    ]);

    $result = $service->getActualSelectedAttributes($selectedAttributes);

    expect($clothingAttribute->is($result->all()[AttributeType::CLOTHING->value]))->toBeTrue();
    expect($colorAttribute->is($result->all()[AttributeType::COLOR->value]))->toBeTrue();
});

test('map all selected attributes', function () {
    /** @var AttributeServiceInterface $service */
    $service = app()->make(AttributeServiceInterface::class);

    /** @var ProductClothingAttribute $clothingAttribute */
    $clothingAttribute = ProductClothingAttribute::factory()->create();
    /** @var ProductDimensionAttribute $dimensionAttribute */
    $dimensionAttribute = ProductDimensionAttribute::factory()->create();
    /** @var ProductVolumeAttribute $volumeAttribute */
    $volumeAttribute = ProductVolumeAttribute::factory()->create();
    /** @var ProductColorAttribute $colorAttribute */
    $colorAttribute = ProductColorAttribute::factory()->create();

    $selectedAttributes = collect([
        AttributeType::CLOTHING->value => $clothingAttribute->id,
        AttributeType::DIMENSION->value => $dimensionAttribute->id,
        AttributeType::VOLUME->value => $volumeAttribute->id,
        AttributeType::COLOR->value => $colorAttribute->id,
    ]);

    $result = $service->getActualSelectedAttributes($selectedAttributes);

    expect($clothingAttribute->is($result->all()[AttributeType::CLOTHING->value]))->toBeTrue();
    expect($dimensionAttribute->is($result->all()[AttributeType::DIMENSION->value]))->toBeTrue();
    expect($volumeAttribute->is($result->all()[AttributeType::VOLUME->value]))->toBeTrue();
    expect($colorAttribute->is($result->all()[AttributeType::COLOR->value]))->toBeTrue();
});
