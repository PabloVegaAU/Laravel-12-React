<?php

namespace Database\Factories;

use App\Models\Alumno;
use App\Models\AlumnoTarea;
use App\Models\Tarea;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AlumnoTarea>
 */
class AlumnoTareaFactory extends Factory
{
    protected $model = AlumnoTarea::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $horaInicio = fake()->optional()->dateTimeThisMonth();
        $horaFinal = null;
        if ($horaInicio) {
            $horaFinal = Carbon::instance($horaInicio)->addMinutes(fake()->numberBetween(5, 120));
        }

        return [
            'alumno_id' => Alumno::factory(),
            'tarea_id' => Tarea::factory(),
            'nota_final' => fake()->optional()->numberBetween(0, 20),
            'hora_inicio' => $horaInicio,
            'hora_final' => $horaFinal,
            'tiempo_transcurrido' => $horaInicio && $horaFinal ? $horaFinal->diff($horaInicio)->format('%H:%I:%S') : null,
            'estado' => fake()->randomElement(['SIN RESPONSE', 'RESPONDIDO', 'CALIFICADO']),
        ];
    }
}
