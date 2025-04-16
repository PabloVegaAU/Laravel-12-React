<?php

namespace Database\Factories;

use App\Models\Alumno;
use App\Models\Level;
use App\Models\Perfil;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlumnoFactory extends Factory
{
    protected $model = Alumno::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()
                ->has(Perfil::factory()->state(function (array $attributes, User $user) {
                    return ['nombre' => $user->name];
                }))
                ->create()
                ->id,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Alumno $alumno) {

            if ($alumno->user) {
                // ASIGNAR EL ROL ALUMNO AL USUARIO
                $alumno->user->assignRole('Alumno');
                // CREAR UN NIVEL PARA EL ALUMNO
                Level::factory()->create(['alumno_id' => $alumno->user->id]);
            }
        });
    }
}
