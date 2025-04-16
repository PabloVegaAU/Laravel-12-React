<?php

namespace Database\Factories;

use App\Models\Alumno;
use App\Models\Trivia;
use App\Models\TriviaIntento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TriviaIntento>
 */
class TriviaIntentoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TriviaIntento::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fechaInicio = fake()->dateTimeBetween('-1 month', 'now');
        $completado = fake()->boolean(80); // 80% de probabilidad de estar completado
        $fechaFin = $completado
            ? fake()->dateTimeBetween(
                $fechaInicio->format('Y-m-d H:i:s'),
                $fechaInicio->format('Y-m-d H:i:s').' +2 hours'
            )
            : null;

        $puntajeMaximo = fake()->randomFloat(2, 10, 100);
        $puntajeTotal = $completado
            ? fake()->randomFloat(2, 0, $puntajeMaximo)
            : 0;

        $porcentajeExito = $completado
            ? round(($puntajeTotal / $puntajeMaximo) * 100, 2)
            : 0;

        $tiempoUtilizado = $completado && $fechaFin
            ? $fechaFin->getTimestamp() - $fechaInicio->getTimestamp()
            : null;

        return [
            'trivia_id' => Trivia::factory(),
            'alumno_id' => Alumno::factory(),
            'intento_numero' => fake()->numberBetween(1, 3),
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'tiempo_utilizado' => $tiempoUtilizado,
            'puntaje_total' => $puntajeTotal,
            'porcentaje_exito' => $porcentajeExito,
            'completado' => $completado,
            'aprobado' => $completado && $porcentajeExito >= 70, // 70% para aprobar
            'es_simulacro' => fake()->boolean(20), // 20% de ser simulacro
            'es_revision' => fake()->boolean(10), // 10% de ser revisión
        ];
    }
}
