<?php

use function Pest\Laravel\get;

test('has authentication page', function () {
    get('/login')->assertStatus(200);
});
