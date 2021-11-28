<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    /**
     * @var int Amount of admin users that get seeded
     */
    public const ADMIN_COUNT = 5;

    /**
     * @var int Amount of normal users that get seeded
     */
    public const NORMAL_USER_COUNT = 20;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->state(["is_admin" => true])
            ->count(self::ADMIN_COUNT)
            ->create();
        User::factory()
            ->state(["is_admin" => false])
            ->count(self::NORMAL_USER_COUNT)
            ->create();
    }
}
