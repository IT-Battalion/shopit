<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\document::factory()->count(1)->create();
    }
}
