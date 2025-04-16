<?php

namespace Database\Factories;

use App\Models\Perfil;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PerfilFactory extends Factory
{
    protected $model = Perfil::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $fechaNac = fake()->dateTimeBetween('-50 years', '-7 years');

        return [
            'user_id' => User::factory(),
            'nombre' => fake()->firstName,
            'apellido' => fake()->lastName,
            'fecha_nac' => $fechaNac,
            'dni' => fake()->unique()->numerify('########'),
            'edad' => Carbon::parse($fechaNac)->age,
            'sexo' => fake()->randomElement(['m', 'f']),
            'direccion' => fake()->streetAddress,
            'distrito' => fake()->city,
        ];
    }
}
