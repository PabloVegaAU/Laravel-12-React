<?php

namespace Database\Factories;

use App\Models\Logro;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogroFactory extends Factory
{
    protected $model = Logro::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => fake()->unique()->word.' '.fake()->word,
            'descripcion' => fake()->sentence,
            'tipo' => fake()->randomElement(['BASICO', 'REGULAR', 'NORMAL', 'BUENO', 'MUY BUENO', 'EXCELENTE']),
            'exp_req' => fake()->optional()->numberBetween(100, 1000),
            'es_comprable' => fake()->boolean,
        ];
    }
}
