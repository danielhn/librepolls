<?php

namespace Tests\Feature;

use App\Models\Choice;
use App\Models\Poll;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VoteTest extends TestCase
{
    use RefreshDatabase;
    public function test_vote_can_be_created_if_valid(): void
    {
        $poll = Poll::factory()->has(
            Choice::factory()->count(rand(2, config('librepolls.choices.max_per_poll')))
        )->create();

        $firstChoice = $poll->choices()->first()->id;

        $response = $this->post(route('storeVote', $poll->slug),
            ['choices' => [$firstChoice]]
        );

        $response->assertSessionDoesntHaveErrors();

        $this->assertDatabaseCount('votes', 1);
        $this->assertDatabaseCount('choice_vote', 1);
    }

    public function test_vote_cannot_be_created_if_using_choice_from_different_poll(): void
    {
        $poll = Poll::factory()->has(
            Choice::factory()->count(rand(2, config('librepolls.choices.max_per_poll')))
        )->create();

        $poll2 = Poll::factory()->has(
            Choice::factory()->count(rand(2, config('librepolls.choices.max_per_poll')))
        )->create();

        $firstChoice = $poll2->choices()->first()->id;

        $response = $this->post(route('storeVote', $poll->slug),
            ['choices' => [$firstChoice]]
        );

        $response->assertSessionHasErrors();

        $this->assertDatabaseCount('votes', 0);
        $this->assertDatabaseCount('choice_vote', 0);
    }

    public function test_vote_cannot_be_created_twice_if_poll_has_token_duplication_check(): void
    {
        $poll = Poll::factory()->has(
            Choice::factory()->count(rand(2, config('librepolls.choices.max_per_poll')))
        )->create(['voter_identifier' => 'token']);

        $firstChoice = $poll->choices()->first()->id;

        $response = $this->post(route('storeVote', $poll->slug),
            ['choices' => [$firstChoice]]
        );

        $response->assertCookie($poll->slug);
        $cookie = $response->getCookie($poll->slug);

        $response = $this->withCookie($cookie->getName(), $cookie->getValue())
            ->post(route('storeVote', $poll->slug),
            ['choices' => [$firstChoice]]
        );

        $response->assertRedirectToRoute('resultsPoll', $poll->slug);
    }

    public function test_vote_cannot_be_created_twice_if_poll_has_ip_duplication_check(): void
    {
        $poll = Poll::factory()->has(
            Choice::factory()->count(rand(2, config('librepolls.choices.max_per_poll')))
        )->create(['voter_identifier' => 'ip']);

        $firstChoice = $poll->choices()->first()->id;

        $this->post(route('storeVote', $poll->slug),
            ['choices' => [$firstChoice]]
        );

        $response = $this->post(route('storeVote', $poll->slug),
                ['choices' => [$firstChoice]]
        );

        $response->assertRedirectToRoute('resultsPoll', $poll->slug);
    }
}
