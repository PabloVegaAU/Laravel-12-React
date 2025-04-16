<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TareaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'titulo' => $this->faker->unique()->text(10),
            'descripcion' => $this->faker->paragraph(),
            'tipo' => $this -> faker->randomElement(['0','1']),
            'estado' => $this -> faker->randomElement(['0','1']),
        ];
    }
}
