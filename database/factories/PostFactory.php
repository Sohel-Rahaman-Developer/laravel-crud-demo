<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'   => $this->faker->unique()->sentence(4),
            'content' => $this->faker->boolean(80) ? $this->faker->paragraphs(2, true) : null,
        ];
    }
}
