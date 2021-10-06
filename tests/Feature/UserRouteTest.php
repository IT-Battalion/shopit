<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRouteTest extends TestCase
{
    /**
     * @test
     */
    public function showUserPageAccessibleTest() {
        $user = User::factory()->create();
        $response = $this->get('/user/' . $user['id']);
        $response->assertStatus(200);
    }
}
