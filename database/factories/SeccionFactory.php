<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SeccionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->name,
            'grado_id' => random_int(1,6)
        ];
    }
}
