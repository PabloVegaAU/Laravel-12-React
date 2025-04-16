<?php

namespace Database\Factories;

use App\Models\Aula;
use App\Models\Grado;
use App\Models\Seccion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Aula>
 */
class AulaFactory extends Factory
{
    protected $model = Aula::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'grado_id' => Grado::factory(),
            'seccion_id' => Seccion::factory(),
            'anio' => fake()->numberBetween(date('Y') - 1, date('Y') + 1),
        ];
    }
}
