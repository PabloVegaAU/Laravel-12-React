<?php

namespace Database\Factories;

use App\Models\AulaDocenteMateria;
use App\Models\Carpeta;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarpetaFactory extends Factory
{
    protected $model = Carpeta::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $fechaInicio = fake()->dateTimeBetween('-1 month', '+1 month');

        return [
            'aulas_docentes_materias_id' => AulaDocenteMateria::factory(),
            'titulo' => 'Unidad '.fake()->randomNumber(1).': '.fake()->catchPhrase,
            'descripcion' => fake()->sentence,
            'fecha_inicio' => $fechaInicio,
            'fecha_final' => Carbon::instance($fechaInicio)->addWeeks(fake()->numberBetween(1, 4)),
            'estado' => fake()->randomElement(['ABIERTO', 'CERRADO']),
        ];
    }
}
