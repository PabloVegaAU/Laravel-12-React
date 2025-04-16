<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MensajeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'color' => fake()->hexColor(),
            'mensaje' => fake()->sentence(),
        ];
    }
}
