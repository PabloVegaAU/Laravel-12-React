<?php

namespace Database\Factories;

use App\Models\Alumno;
use App\Models\Nivel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Nivel>
 */
class NivelFactory extends Factory
{
    protected $model = Nivel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'alumno_id' => Alumno::factory(),
            'nivel' => 1,
            'exp' => 0,
            'exp_ac' => 0,
        ];
    }
}
