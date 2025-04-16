<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
            return [
                "url" => "_logros/" . $this->faker->image("public\storage\_logros", 640, 480, null, false)
            ];
    }
}
