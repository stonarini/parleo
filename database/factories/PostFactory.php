<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use DateTime;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->bs(),
            'content' => fake()->realTextBetween(160, 200, 2),
            'image' => fake()->imageUrl(10),
            'date' => new DateTime(),
            'access' => 'public',
            'commentable' => true,
        ];
    }
}
