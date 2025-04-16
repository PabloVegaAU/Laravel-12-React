<?php

namespace Database\Factories;

use App\Models\Alumno;
use App\Models\Trivia;
use App\Models\TriviaIntento;
use App\Models\TriviaPregunta;
use App\Models\TriviaPreguntaOpcion;
use App\Models\TriviaRespuesta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TriviaRespuesta>
 *
 * Factory para el modelo TriviaRespuesta.
 * Genera datos de prueba para las respuestas de los alumnos a las preguntas de trivias.
 */
class TriviaRespuestaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TriviaRespuesta::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Obtener una pregunta existente o crear una nueva
        $pregunta = TriviaPregunta::inRandomOrder()->first() ?? TriviaPregunta::factory()->create();

        // Obtener la trivia relacionada
        $trivia = $pregunta->trivia ?? Trivia::factory()->create();

        // Obtener un intento existente o crear uno nuevo
        $intento = TriviaIntento::inRandomOrder()->first() ?? TriviaIntento::factory()->create([
            'trivia_id' => $trivia->id,
        ]);

        // Obtener una opción existente para la pregunta o crear una nueva
        $opcion = TriviaPreguntaOpcion::where('trivia_pregunta_id', $pregunta->id)
            ->inRandomOrder()
            ->first() ?? TriviaPreguntaOpcion::factory()->create([
                'trivia_pregunta_id' => $pregunta->id,
            ]);

        // Obtener el alumno del intento o crear uno nuevo
        $alumno = $intento->alumno ?? Alumno::inRandomOrder()->first() ?? Alumno::factory()->create();

        // Calcular tiempo de respuesta (entre 5 y 120 segundos por pregunta)
        $tiempoRespuesta = fake()->numberBetween(5, 120);

        // Determinar si la respuesta es correcta basada en la opción
        $esCorrecta = $opcion->es_correcta ?? fake()->boolean(30); // 30% de ser correcta si no hay opción

        // Calcular puntaje obtenidos (máximo 10 puntaje por pregunta)
        $puntajeObtenido = $esCorrecta
            ? fake()->randomFloat(2, 5, 10) // Entre 5 y 10 puntaje si es correcta
            : fake()->randomFloat(2, 0, 3); // Hasta 3 puntaje si es incorrecta

        return [
            'trivia_id' => $trivia->id,
            'trivia_pregunta_id' => $pregunta->id,
            'trivia_pregunta_opcion_id' => $opcion->id,
            'alumno_id' => $alumno->user_id,
            'trivia_intento_id' => $intento->id,
            'respuesta_texto' => fake()->boolean(10) ? fake()->sentence() : null, // 10% de tener texto
            'puntaje_obtenido' => $puntajeObtenido,
            'tiempo_respuesta' => $tiempoRespuesta,
            'es_correcta' => $esCorrecta
        ];
    }
}
