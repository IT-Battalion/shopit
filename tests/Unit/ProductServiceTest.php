<?php

use App\Models\Admin;
use App\Models\ProductCategory;

beforeEach(function () {
    Admin::factory()->create();
    ProductCategory::factory()->create(['name' => 'Test']);
});

test('create product without product images', function () {

});

test('create product without attributes', function () {

});

test('create product without name', function () {

});

test('create product without description', function () {

});

test('create product without price', function () {

});

test('create product without highlighted', function () {

});

test('create highlighted product', function () {

});

test('create product with clothing attribute', function () {

});

test('create product with color attribute', function () {

});

test('create product with multiple color attributes', function () {

});

test('create product with color attribute missing name parameter', function () {

});

test('create product with color attribute missing color parameter', function () {

});

test('create product with multiple color attributes missing name parameter', function () {

});

test('create product with multiple color attributes missing color parameter', function () {

});

test('create product with multiple color attributes missing multiple name parameters', function () {

});

test('create product with multiple color attributes missing multiple color parameters', function () {

});

test('create product with dimension attribute', function () {

});

test('create product with dimension attribute missing width', function () {

});

test('create product with dimension attribute missing height', function () {

});

test('create product with dimension attribute missing depth', function () {

});

test('create product with multiple dimension attributes', function () {

});

test('create product with multiple dimension attributes missing width', function () {

});

test('create product with multiple dimension attributes missing height', function () {

});

test('create product with multiple dimension attributes missing depth', function () {

});

test('create product with multiple dimension attributes missing widths', function () {

});

test('create product with multiple dimension attributes missing heights', function () {

});

test('create product with multiple dimension attributes missing depths', function () {

});

test('create product with volume attribute', function () {

});

test('create product with multiple volume attributes', function () {

});

test('create product with one product image', function () {

});

test('create product with multiple product images', function () {

});

test('create product with multiple attributes', function () {

});

test('create product with one attribute', function () {

});

test('create casual product', function () {

});

test('delete product', function () {

});

test('highlight existing product', function () {

});

test('unhighlight existing highlighted product', function () {

});

test('edit product add images', function () {

});

test('edit product remove images', function () {

});

test('edit product change name', function () {

});

test('edit product change price', function () {

});

test('edit product change description', function () {

});

test('edit product add attributes', function () {

});

test('edit product remove attributes', function () {

});

test('edit product add clothing attribute', function () {

});

test('edit product remove clothing attribute', function () {

});

test('edit product add color attribute', function () {

});

test('edit product remove color attribute', function () {

});

test('edit product add volume attribute', function () {

});

test('edit product remove volume attribute', function () {

});

test('edit product add dimension attribute', function () {

});

test('edit product remove dimension attribute', function () {

});
