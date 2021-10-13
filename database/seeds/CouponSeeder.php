<?php

namespace Database\Seeders;

use App\Models\CouponCode;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CouponCode::factory()->count(5)->create();
    }
}
