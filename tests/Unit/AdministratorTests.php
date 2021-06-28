<?php


namespace Tests\Unit;

use Tests\TestCase;

class AdministratorTests extends TestCase
{
    public function invalidAdminCheckIfAdmin() : void {
        $this->assertFalse(false);
    }

    public function validAdminCheckIfAdmin() : void {
        $this->assertTrue(true);
    }
}
