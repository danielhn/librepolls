<?php

namespace Tests\Feature;

use App\Models\Choice;
use App\Models\Poll;
use Database\Factories\PollFactory;
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

    public function test_poll_cannot_be_created_if_there_are_validation_errors(): void
    {
        $poll = [
            'title' => '',
            'multiple-choices' => 'test'
        ];

        $choices = ['choices' => []];

        // Exceed the maximum choices allowed
        for ($i = 0; $i < 12; $i++) {
            $choices['choices'][] = ['text' => fake()->realText(rand(10, 50))];
        }

        $data = array_merge($poll, $choices);

        $response = $this->post('/polls', $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['title', 'choices', 'multiple-choices']);

        $this->assertDatabaseCount('polls', 0);
        $this->assertDatabaseCount('choices', 0);
    }

    public function test_poll_can_be_seen_for_casting_votes_if_exists()
    {
        $poll = Poll::factory()->has(
            Choice::factory()->count(rand(2,8))
        )->create();

        $response = $this->get('/polls/' . $poll->id);

        $response->assertStatus(200);
        $response->assertSee($poll->title);
        $response->assertSee($poll->choices->first()->text);
    }
}
