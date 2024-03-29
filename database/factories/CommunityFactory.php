<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommunityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => str_replace(' ', '-', strtolower(fake()->catchPhrase())),
            'description' => fake()->realTextBetween(160, 200, 2),
            'banner' => 'img/r/default',
        ];
    }
}
