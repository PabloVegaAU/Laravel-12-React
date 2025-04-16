<?php

namespace Database\Factories;

use App\Models\Trivia;
use App\Models\TriviaPregunta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TriviaPregunta>
 *
 * Factory para el modelo TriviaPregunta.
 * Genera datos de prueba para las preguntas de las trivias.
 */
class TriviaPreguntaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TriviaPregunta::class;

    /**
     * Tipos de preguntas disponibles.
     *
     * @var array
     */
    protected $tiposPregunta = [
        'opcion_unica',
        'opcion_multiple',
        'verdadero_falso',
        'emparejamiento',
        'ordenar_opciones',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'trivia_id' => Trivia::factory(),
            'pregunta' => fake()->sentence().'?',
            'explicacion' => fake()->optional(0.7)->paragraph(),
            'imagen' => fake()->optional(0.3)->imageUrl(640, 480, 'education'),
            'tipo' => fake()->randomElement($this->tiposPregunta),
            'puntaje' => fake()->randomFloat(2, 0.5, 5),
            'orden' => fake()->unique()->numberBetween(1, 100),
            'es_obligatoria' => fake()->boolean(80)
        ];
    }
}
