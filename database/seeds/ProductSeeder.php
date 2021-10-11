<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()
            ->has(User::factory()->state(function (array $attributes, User $user) {
                return ['isAdmin' => true];
            }), 'created_by')
            ->has(User::factory()->state(function (array $attributes, User $user) {
                return ['isAdmin' => true];
            }), 'updated_by')
            ->count(200)->create();
    }
}
