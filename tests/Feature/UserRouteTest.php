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
        $user = User::factory(['isAdmin' => false])->create();
        $response = $this->actingAs($user)->get('/user/' . User::factory()->create()->getAttribute('id'));
        $response->assertStatus(500);
    }

    /**
     * @test
     */
    public function showUserAsAdminPageAccessibleTest() {
        $user = User::factory(['isAdmin' => true])->create();
        $response = $this->actingAs($user)->get('/user/' . User::factory()->create()->getAttribute('id'));
        $response->assertStatus(200);
    }
}
