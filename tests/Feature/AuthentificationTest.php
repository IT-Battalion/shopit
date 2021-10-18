<?php

use function Pest\Laravel\get;

it('has authentification page', function () {
    $response = get('/login');

    $response->assertStatus(200);
});
