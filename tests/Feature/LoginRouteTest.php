<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LoginRouteTest extends TestCase
{
    /**
     * @test
     */
    public function loginPostWithArgsPageAccessibleTest() : void {
        $user = User::factory()->create();
        $this->post('/login', ['username' => $user->getAttribute('username'), 'password' => 'test']);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @test
     */
    public function loginPostWithFalseArgsPageAccessibleTest() : void {
        $user = User::factory()->create();
        $response = $this->post('/login', ['username' => $user->getAttribute('username'), 'password' => 'falsePW']);
        $response->assertStatus(302);
    }

    //TODO: test remember me
    //TODO: test ldap cases
}
