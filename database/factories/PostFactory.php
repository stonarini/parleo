<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->bs(), 
			'content' => fake()->realTextBetween(160, 200, 2),
			'image' => fake()->imageUrl(10),
        ];
    }
}
