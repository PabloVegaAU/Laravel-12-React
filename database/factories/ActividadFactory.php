<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ActividadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'descripcion' => $this->faker->paragraph(),
            'recurso' => $this->faker->optional()->url(),
            'tipo' => $this->faker->randomElement(['0','1','2','3']),
            'puntaje_max' => $this->faker->randomFloat(1,1,5)
        ];
    }
}
