<?php

use App\Services\Products\ProductService;

test('create product', function () {
    $service = app()->make(ProductService::class);
    $service->create('test', 33.33, 'The test product should be deleted soonTM');
});

test('create product images', function () {

});

test('set thumbnail image', function () {

});

test('create product attributes', function () {

});

test('check product attributes', function () {

});

test('delete product', function () {

});
