<?php

namespace Database\Factories;

use App\Models\Seccion;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeccionFactory extends Factory
{
    protected $model = Seccion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => fake()->randomElement(['A', 'B', 'C', 'D']),
        ];
    }
}
