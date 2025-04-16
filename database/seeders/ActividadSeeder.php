<?php

namespace Database\Seeders;

use App\Models\Actividad;
use App\Models\Tarea;
use Illuminate\Database\Seeder;

class ActividadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // OBTENER TODAS LAS TAREAS
        $tareas = Tarea::all();

        // CREAR ACTIVIDADES PARA CADA TAREA
        foreach ($tareas as $tarea) {
            Actividad::factory()->create([
                'tarea_id' => $tarea->id,
            ]);
        }
    }
}
