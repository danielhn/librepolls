<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Poll>
 */
class PollFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => Str::random(8),
            'title' => fake()->realText(rand(10,50)),
            'description' => fake()->realText(rand(30,240)),
            'password' => fake()->optional()->password(16,32),
            'locked' => fake()->boolean(),
            'multiple_choices' => fake()->boolean(),
            'locks_on' => fake()->optional()->dateTimeBetween('now', '1 week'),
            'voter_identifier' => fake()->randomElement(['ip', 'token', 'none'])
        ];
    }
}
