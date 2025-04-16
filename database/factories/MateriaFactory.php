<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MateriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "nombre"=>$this->faker->realText(20),
            "descripcion"=>$this->faker->realText(100)
        ];
    }
}
