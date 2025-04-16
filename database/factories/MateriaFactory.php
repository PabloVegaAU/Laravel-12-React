<?php

namespace Database\Factories;

use App\Models\Materia;
use Illuminate\Database\Eloquent\Factories\Factory;

class MateriaFactory extends Factory
{
    protected $model = Materia::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => fake()->randomElement(['Matemáticas', 'Lenguaje', 'Ciencias Naturales', 'Ciencias Sociales', 'Inglés', 'Arte', 'Educación Física']),
            'descripcion' => fake()->sentence,
        ];
    }
}
