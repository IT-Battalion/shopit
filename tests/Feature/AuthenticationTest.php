<?php

use function Pest\Laravel\get;

/**
 * Check if the Authentication is accessible
 * without session or token
 */
it('has authentication page', function () {
    get('/login')->assertStatus(200);
});

/**
 * Check if Authentication is skipped if token is set
 */
test('skipped if token is set', function () {

});

/**
 * Check if Authentication is skipped if Session is set
 */
test('skipped if session is set', function () {

});

/**
 * Check if User is redirected to correct page when
 * he comes from a page but wasn't logged in
 */
test('is user redirected to correct page if he comes from page which requires beeing logged in', function () {

});

/**
 * Check if login with correct credentials works
 */
test('login works with correct credentials', function () {

});

/**
 * Check if login with incorrect credentials works
 */
test('login does not work with incorrect credentials', function () {

});
