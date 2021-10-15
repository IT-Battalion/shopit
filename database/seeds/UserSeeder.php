<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->state(["isAdmin" => true])
            ->count(7)
            ->create();
        User::factory()
            ->state(["isAdmin" => false])
            ->count(20)
            ->create(20);
    }
}
