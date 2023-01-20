<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use DateTime;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'content' => fake()->realTextBetween(10, 50),
            'image' => fake()->imageUrl(10),
            'date' => new DateTime(),
        ];
    }
}
