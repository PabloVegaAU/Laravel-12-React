<?php

namespace Database\Factories;

use App\Models\Actividad;
use App\Models\Tarea;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActividadFactory extends Factory
{
    protected $model = Actividad::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tipo = fake()->randomElement(['PREGUNTA CORTA', 'PREGUNTA LARGA', 'VIDEO', 'LINK']);

        return [
            'tarea_id' => Tarea::factory(),
            'descripcion' => fake()->sentence,
            'recurso' => ($tipo === 'VIDEO' || $tipo === 'LINK') ? fake()->url : null,
            'tipo' => $tipo,
            'puntaje_max' => fake()->randomElement([5, 10, 15, 20]),
        ];
    }
}
