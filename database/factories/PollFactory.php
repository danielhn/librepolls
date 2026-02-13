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
            'slug' => Str::random(config('librepolls.polls.slug_length')),
            'title' => fake()->realText(rand(10, config('librepolls.polls.title_max_length'))),
            'description' => fake()->realText(rand(10, config('librepolls.polls.description_max_length'))),
            'locked' => fake()->boolean(),
            'multiple_choices' => fake()->boolean(),
            'voter_identifier' => fake()->randomElement(['ip', 'token', 'none'])
        ];
    }
}
