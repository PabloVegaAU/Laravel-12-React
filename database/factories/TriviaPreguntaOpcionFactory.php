<?php

namespace Database\Factories;

use App\Models\TriviaPregunta;
use App\Models\TriviaPreguntaOpcion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TriviaPreguntaOpcion>
 *
 * Factory para el modelo TriviaPreguntaOpcion.
 * Genera datos de prueba para las opciones de respuesta de las preguntas de trivias.
 */
class TriviaPreguntaOpcionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TriviaPreguntaOpcion::class;

    /**
     * Tipos de opciones para generar datos más realistas.
     */
    protected array $tiposOpciones = [
        'afirmacion' => [
            'Verdadero', 'Falso', 'A veces', 'Depende del contexto'
        ],
        'seleccion' => [
            'Opción A', 'Opción B', 'Opción C', 'Opción D', 'Opción E'
        ],
        'completar' => [
            'es una opción', 'podría ser correcta', 'es la respuesta', 'es válida'
        ]
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tipo = fake()->randomElement(['afirmacion', 'seleccion', 'completar']);
        $opcion = $this->generarOpcion($tipo);

        return [
            'trivia_pregunta_id' => TriviaPregunta::factory(),
            'texto' => $opcion,
            'imagen' => fake()->optional(0.2)->imageUrl(),
            'audio_url' => fake()->optional(0.2)->url(),
            'color' => fake()->optional(0.2)->hexColor(),
            'es_correcta' => fake()->boolean(20), // 20% de ser correcta por defecto
            'puntaje' => fake()->optional(0.2)->numberBetween(1, 10, 0.5),
            'orden' => fake()->unique()->numberBetween(1, 10),
            'clave_emparejamiento' => fake()->optional(0.2)->randomElement(['A', 'B', 'C', 'D']),
        ];
    }
}
