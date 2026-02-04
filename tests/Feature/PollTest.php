<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PollTest extends TestCase
{
    use RefreshDatabase;
    public function test_poll_can_be_created_if_valid(): void
    {
        $poll = [
            'title' => fake()->realText(60),
            'multiple-choices' => fake()->boolean()
        ];

        $choices = ['choices' => [
            ['text' => fake()->realText(50)],
            ['text' => fake()->realText(40)],
            ['text' => fake()->realText(30)],
        ]];

        $data = array_merge($poll, $choices);

        $response = $this->post('/polls', $data);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseCount('polls', 1);
        $this->assertDatabaseCount('choices', 3);
    }
}
