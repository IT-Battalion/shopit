<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    /**
     * @var int Amount of admin users that get seeded
     */
    public const adminCount = 5;

    /**
     * @var int Amount of normal users that get seeded
     */
    public const normalUserCount = 20;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->state(["isAdmin" => true])
            ->count(self::adminCount)
            ->create();
        User::factory()
            ->state(["isAdmin" => false])
            ->count(self::normalUserCount)
            ->create();
    }
}
