<?php


namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class AdministratorTest extends TestCase
{
    /**
     * @test
     */
    public function testIsUserAdmin() {
        $user = User::factory(['isAdmin' => true])->create();
        self::assertTrue($user['isAdmin']);
    }

    /**
     * @test
     */
    public function testIsUserNotAdmin() {
        $user = User::factory(['isAdmin' => false])->create();
        self::assertFalse($user['isAdmin']);
    }
}
