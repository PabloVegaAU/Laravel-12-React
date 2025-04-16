<?php

namespace Database\Factories;

use App\Models\Grado;
use Illuminate\Database\Eloquent\Factories\Factory;

class GradoFactory extends Factory
{
    protected $model = Grado::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => fake()->randomElement(['1ro', '2do', '3ro', '4to', '5to', '6to']),
            'nivel' => fake()->randomElement(['PRIMARIA', 'SECUNDARIA']),
        ];
    }
}
