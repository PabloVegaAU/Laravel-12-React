<?php

namespace Database\Factories;

use App\Models\Aula;
use App\Models\AulaDocenteMateria;
use App\Models\Docente;
use App\Models\Materia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AulaDocenteMateria>
 */
class AulaDocenteMateriaFactory extends Factory
{
    protected $model = AulaDocenteMateria::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'aula_id' => Aula::factory(),
            'docente_id' => Docente::factory(),
            'materia_id' => Materia::factory(),
        ];
    }
}
