<?php

namespace Database\Factories;

use App\Models\Docente;
use App\Models\Perfil;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocenteFactory extends Factory
{
    protected $model = Docente::class;

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
        return $this->afterMaking(function (Docente $docente) {
            if ($docente->user) {
                // ASIGNAR EL ROL DOCENTE AL USUARIO
                $docente->user->assignRole('Docente');
            }
        });
    }
}
