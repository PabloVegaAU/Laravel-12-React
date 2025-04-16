<?php

namespace Database\Seeders;

use App\Models\Logro;
use Illuminate\Database\Seeder;

class LogroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Logro::factory()->count(10)->create();
    }
}
