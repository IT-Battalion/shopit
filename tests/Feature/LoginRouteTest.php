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
        $response = $this->post('/login', ['username' => $user['username'], 'password' => 'test']);
        $response->assertStatus(200);
    }

    //TODO: test remember me
    //TODO: test ldap cases
}
