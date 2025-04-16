<?php

namespace Database\Factories;

use App\Models\Alumno;
use App\Models\Level;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Level>
 */
class LevelFactory extends Factory
{
    protected $model = Level::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'alumno_id' => Alumno::factory(),
            'level' => 1,
            'exp' => 0,
            'exp_ac' => 0,
        ];
    }
}
