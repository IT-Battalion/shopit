<?php

namespace Tests\Feature;

use App\Models\User;
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
        $user = User::factory(['isAdmin' => true])->create();
        $response = $this->actingAs($user)->get('/admin');
        $response->assertLocation('/admin');
    }

    /**
     * @test
     */
    public function adminUserPageAccessibleTest() : void {
        $user = User::factory(['isAdmin' => false])->create();
        $response = $this->actingAs($user)->get('/admin');
        $response->assertLocation('');
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
}
