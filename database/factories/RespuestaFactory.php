<?php

namespace Database\Factories;

use App\Models\Actividad;
use App\Models\Alumno;
use App\Models\Respuesta;
use Illuminate\Database\Eloquent\Factories\Factory;

class RespuestaFactory extends Factory
{
    protected $model = Respuesta::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $actividad = Actividad::factory()->create();

        return [
            'actividad_id' => $actividad->id,
            'alumno_id' => Alumno::factory(),
            'descripcion' => fake()->sentence,
            'puntaje' => $actividad->puntaje_max ? fake()->numberBetween(0, $actividad->puntaje_max) : null,
        ];
    }
}
