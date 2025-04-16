<?php

namespace Database\Factories;

use App\Models\Alumno;
use App\Models\AlumnoLogro;
use App\Models\Logro;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AlumnoLogro>
 */
class AlumnoLogroFactory extends Factory
{
    protected $model = AlumnoLogro::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'alumno_id' => Alumno::factory(),
            'logro_id' => Logro::factory(),
        ];
    }
}
