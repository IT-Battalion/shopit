<?php

namespace Tests\Feature;

use Tests\TestCase;

class RouteAccessibleTests extends TestCase
{
    public function loginPageAccessibleTest() : void {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function homePageAccessibleTest() : void {
        $response = $this->get('/home');
        $response->assertStatus(200);
    }

    public function adminPageAccessibleTest() : void {
        $response = $this->get('/admin');
        $response->assertStatus(200);
    }

    public function logoutPageAccessibleTest() {
        $response = $this->get('/logout');
        $response->assertStatus(200);
    }

    public function profilePageAccessibleTest() {
        $response = $this->get('/profile');
        $response->assertStatus(200);
    }

    public function shoppingCartPageAccessibleTest() {
        $response = $this->get('/shopping-cart');
        $response->assertStatus(200);
    }
}
