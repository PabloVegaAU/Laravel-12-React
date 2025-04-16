<?php

namespace Database\Factories;

use App\Models\Carpeta;
use App\Models\Tarea;
use Illuminate\Database\Eloquent\Factories\Factory;

class TareaFactory extends Factory
{
    protected $model = Tarea::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'carpeta_id' => Carpeta::factory(),
            'titulo' => fake()->bs,
            'descripcion' => fake()->paragraph,
            'tipo' => fake()->randomElement(['TAREA', 'RETO']),
            'estado' => 'ACTIVO',
        ];
    }
}
