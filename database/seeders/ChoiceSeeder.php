<?php

namespace Database\Seeders;

use App\Models\Choice;
use App\Models\Poll;
use Illuminate\Database\Seeder;

class ChoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $poll = Poll::factory()->create();
        Choice::factory()->count(rand(2, config('librepolls.choices.max_per_poll')))->for($poll)->create();
    }
}
