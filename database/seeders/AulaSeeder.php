<?php

namespace Database\Seeders;

use App\Models\Aula;
use App\Models\Grado;
use App\Models\Seccion;
use Illuminate\Database\Seeder;

class AulaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // CREAR SESIONES A A E
        $secciones = ['A', 'B', 'C', 'D', 'E'];

        for ($i = 0; $i < count($secciones); $i++) {
            Seccion::firstOrCreate([
                'nombre' => $secciones[$i],
            ]);
        }

        // SE CREA LOS GRADOS PARA PRIMARIA Y SECUNDARIA
        $grados = ['PRIMERO', 'SEGUNDO', 'TERCERO', 'CUARTO', 'QUINTO', 'SEXTO'];

        // PARA PRIMERA Y SECUNDARIA
        for ($i = 0; $i < count($grados); $i++) {
            Grado::firstOrCreate([
                'nombre' => $grados[$i],
                'nivel' => 'PRIMARIA',
            ]);
        }

        for ($i = 0; $i < count($grados) - 1; $i++) {
            Grado::firstOrCreate([
                'nombre' => $grados[$i],
                'nivel' => 'SECUNDARIA',
            ]);
        }

        // CREAR AULAS
        $anioActual = date('Y');
        foreach ($grados as $grado) {
            foreach ($secciones as $seccion) {
                Aula::firstOrCreate([
                    'grado_id' => Grado::where('nombre', $grado)->first()->id,
                    'seccion_id' => Seccion::where('nombre', $seccion)->first()->id,
                    'anio' => $anioActual,
                ]);
            }
        }
    }
}
