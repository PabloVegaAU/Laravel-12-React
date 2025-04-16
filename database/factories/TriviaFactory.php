<?php

namespace Database\Factories;

use App\Models\Trivia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trivia>
 *
 * Factory para el modelo Trivia.
 * Genera datos de prueba para las trivias del sistema.
 */
class TriviaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Trivia::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => 'Trivia: '.fake()->sentence(rand(3, 6)),
            'descripcion' => '',
            'image' => '',
            'estado' => 'activa',
            'puntaje_max' => fake()->randomFloat(2, 10, 100),
            'tiempo_limite' => fake()->numberBetween(5, 120),
            'intentos_permitidos' => fake()->numberBetween(1, 3),
            'mostrar_respuestas' => fake()->boolean(),
            'mostrar_puntaje' => fake()->boolean()
        ];
    }
}
