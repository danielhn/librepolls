<?php

namespace Tests\Feature;

use App\Models\Choice;
use App\Models\Poll;
use Database\Factories\PollFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PollTest extends TestCase
{
    use RefreshDatabase;
    public function test_poll_can_be_created_if_valid(): void
    {
        $poll = [
            'title' => fake()->realText(rand(10, config('librepolls.polls.title_max_length'))),
            'description' => fake()->realText(rand(10, config('librepolls.polls.description_max_length'))),
            'voter-identifier' => fake()->randomElement(['ip', 'token', 'none']),
        ];

        $choices = ['choices' => []];

        for ($i = 0; $i < config('librepolls.choices.max_per_poll'); $i++) {
            $choices['choices'][] = ['text' =>
                fake()->realText(rand(10, config('librepolls.choices.max_text_length')))
            ];
        }

        $data = array_merge($poll, $choices);

        $response = $this->post('/polls', $data);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseCount('polls', 1);
        $this->assertDatabaseCount('choices', config('librepolls.choices.max_per_poll'));
    }

    public function test_poll_cannot_be_created_if_there_are_validation_errors(): void
    {
        $poll = [
            'title' => '',
            'voter-identifier' => 'other',
            'multiple-choices' => 'test'
        ];

        $choices = ['choices' => []];

        // Exceed the maximum choices allowed on purpose
        for ($i = 0; $i <= config('librepolls.choices.max_per_poll'); $i++) {
            $choices['choices'][] = ['text' =>
                fake()->realText(rand(10, config('librepolls.choices.max_text_length')))
            ];
        }

        $data = array_merge($poll, $choices);

        $response = $this->post('/polls', $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['title', 'choices', 'multiple-choices', 'voter-identifier']);

        $this->assertDatabaseCount('polls', 0);
        $this->assertDatabaseCount('choices', 0);
    }

    public function test_poll_can_be_seen_for_casting_votes_if_exists()
    {
        $poll = Poll::factory()->has(
            Choice::factory()->count(rand(2, config('librepolls.choices.max_per_poll')))
        )->create();

        $response = $this->get('/' . $poll->slug);

        $response->assertStatus(200);
        $response->assertSee($poll->title);
        $response->assertSee($poll->choices->first()->text);
    }
}
