<?php

namespace Database\Seeders;

use App\Models\Carpeta;
use App\Models\Tarea;
use Illuminate\Database\Seeder;

class TareaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Obtener todas las carpetas
        $carpetas = Carpeta::all();

        // Crear tareas para cada carpeta
        foreach ($carpetas as $carpeta) {
            Tarea::create([
                'titulo' => 'Tarea de '.$carpeta->id,
                'descripcion' => 'Descripción de la tarea',
                'tipo' => 'TAREA',
                'estado' => 'ACTIVO',
                'carpeta_id' => $carpeta->id,
            ]);
        }
    }
}
