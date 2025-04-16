<?php

namespace Database\Factories;

use App\Models\Alumno;
use App\Models\Aula;
use App\Models\AulaAlumno;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AulaAlumno>
 */
class AulaAlumnoFactory extends Factory
{
    protected $model = AulaAlumno::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'aula_id' => Aula::factory(),
            'alumno_id' => Alumno::factory(),
            'es_actual' => fake()->boolean(80),
            'estado' => fake()->randomElement(['ACTIVO', 'RETIRADO', 'GRADUADO']),
        ];
    }
}
