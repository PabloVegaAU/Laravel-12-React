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
        // Crea secciones A - E
        $secciones = ['A', 'B', 'C', 'D', 'E'];

        for ($i = 0; $i < count($secciones); $i++) {
            Seccion::firstOrCreate([
                'nombre' => $secciones[$i],
            ]);
        }

        // Se crean los grados para primaria y secundaria
        $grados = ['1ro', '2do', '3ro', '4to', '5to', '6to'];

        // Para primaria
        for ($i = 0; $i < count($grados); $i++) {
            Grado::firstOrCreate([
                'nombre' => $grados[$i],
                'nivel' => 'PRIMARIA',
            ]);
        }

        // Para secundaria
        for ($i = 0; $i < count($grados) - 1; $i++) {
            Grado::firstOrCreate([
                'nombre' => $grados[$i],
                'nivel' => 'SECUNDARIA',
            ]);
        }

        // Crea aulas
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
