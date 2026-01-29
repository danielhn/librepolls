<?php

namespace Database\Seeders;

use App\Models\Choice;
use App\Models\Poll;
use App\Models\Vote;
use Illuminate\Database\Seeder;

class VoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $poll = Poll::factory()->create();

        Vote::factory(2)->has(
            Choice::factory()->for($poll)->count(5)
        )->create();
    }
}
