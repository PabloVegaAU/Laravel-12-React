<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PerfilFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $dt = $this->faker->dateTimeBetween($startDate = '-60 years', $endDate = '-18 years');
        $date = $dt->format("Y-m-d"); // 1994-09-24

        return [
            "apellido" => $this->faker->lastName,
            "fecha_nac" => $date,
            "DNI" => $this->faker->randomNumber(8),
            "edad" => $this->faker->randomNumber(2),
            "sexo" => $this->faker->randomElement(["m","f"]),
            "direccion" => $this->faker->realText(25),
            "distrito" => $this->faker->realText(10)
        ];
    }
}
