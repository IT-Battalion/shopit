<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RouteAccessibleTest extends TestCase
{
    /**
     * @test
     */
    public function loginPageAccessibleTest() : void {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function loginPostPageAccessibleTest() : void {
        $response = $this->post('/login');
        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function loginPostWithArgsPageAccessibleTest() : void {
        $response = $this->post('/login');
        $response->assertStatus(302);
        //TODO: add data
    }

    public function homePageAccessibleTest() : void {
        $response = $this->get('/home');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function adminPageAccessibleTest() : void {
        $response = $this->get('/admin');
        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function adminPageAsAdminAccessibleTest() : void {
        $response = $this->get('/admin');
        $response->assertStatus(302);
        //TODO: add admin user data
    }

    /**
     * @test
     */
    public function adminUserPageAccessibleTest() : void {
        $response = $this->get('/admin');
        $response->assertStatus(302);
        //TODO add user user data
    }

    /**
     * @test
     */
    public function logoutPageAccessibleTest() {
        $response = $this->get('/logout');
        $response->assertStatus(405);
    }

    /**
     * @test
     */
    public function logoutAsLoggedInPageAccessibleTest() {
        $response = $this->get('/logout');
        $response->assertStatus(405);
        //TODO: add user logged in
    }

    /**
     * @test
     */
    public function profilePageAccessibleTest() {
        $response = $this->get('/profile');
        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function profileAsUserPageAccessibleTest() {
        $response = $this->get('/profile');
        $response->assertStatus(302);
        //TODO: add logged in user
    }

    /**
     * @test
     */
    public function shoppingCartPageAccessibleTest() {
        $response = $this->get('/shopping-cart');
        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function shoppingAsUserCartPageAccessibleTest() {
        $response = $this->get('/shopping-cart');
        $response->assertStatus(302);
        //TODO add logged in user
    }

    /**
     * @test
     */
    public function addShoppingCartPageAccessibleTest() {
        $response = $this->post('/shopping-cart/add/{product_id}');
        $response->assertStatus(302);
        //TODO: add id
    }

    /**
     * @test
     */
    public function removeShoppingCartPageAccessibleTest() {
        $response = $this->post('/shopping-cart/remove/{product_id}');
        $response->assertStatus(302);
        //TODO: add id
    }

    /**
     * @test
     */
    public function showUserPageAccessibleTest() {
        $response = $this->get('/user/{id}');
        $response->assertStatus(302);
        //TODO: Add user ID
    }
}
