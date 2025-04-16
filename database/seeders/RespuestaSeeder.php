<?php

namespace Database\Seeders;

use App\Models\Actividad;
use App\Models\Alumno;
use App\Models\Respuesta;
use Illuminate\Database\Seeder;

class RespuestaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Obtener todas las actividades y alumnos
        $actividades = Actividad::all();
        $alumnos = Alumno::all();

        // Crear respuestas para cada actividad y alumno
        foreach ($actividades as $actividad) {
            foreach ($alumnos as $alumno) {
                Respuesta::create([
                    'descripcion' => 'Respuesta de prueba',
                    'puntaje' => rand(0, 10),
                    'actividad_id' => $actividad->id,
                    'alumno_id' => $alumno->user_id,
                ]);
            }
        }
    }
}
