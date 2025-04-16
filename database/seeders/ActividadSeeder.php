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
        // Obtiene todas las tareas
        $tareas = Tarea::all();

        // Crea actividades para cada tarea
        foreach ($tareas as $tarea) {
            Actividad::factory()->create([
                'tarea_id' => $tarea->id,
            ]);
        }
    }
}
