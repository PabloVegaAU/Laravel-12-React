<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LogroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "nombre"=>$this->faker->name,
            "descripcion"=>$this->faker->realText(50),
            "exp_req" => $this->faker->numberBetween($min = 100, $max = 1000),
            "tipo"=>$this->faker->randomElement(["0","1","2","3","4","5"]),
        ];
    }
}
