<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CarpetaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $dt = $this->faker->dateTimeBetween($startDate = '-1 days', $endDate = '+1 days');
        $date1 = $dt->format("Y-m-d"); // 1994-09-24

        $date = date_add($dt , date_interval_create_from_date_string("2 days"));
        $date2 = $date->format("Y-m-d"); // 1994-09-24



        return [
            'titulo' => $this->faker->unique()->word(10),
            'descripcion' => $this->faker->text(100),
            'fecha_inicio' => $date1,
            'fecha_final' => $date2,
            'estado' => $this -> faker->randomElement(['0','1']),
            'materia_id'=> rand(1,10),
            'user_id'=> rand(2,6),
            'seccion_id'=> rand(1,12)
        ];
    }
}
