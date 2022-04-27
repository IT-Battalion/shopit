<?php

namespace Database\Seeders;

use App\Models\document;
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
        document::factory()->count(1)->create();
    }
}
