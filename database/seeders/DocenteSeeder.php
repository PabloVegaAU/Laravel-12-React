<?php

namespace Database\Seeders;

use App\Models\Docente;
use Illuminate\Database\Seeder;

class DocenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // CREAR DOCENTES
        Docente::factory()->count(5)->create();
    }
}
