<?php

namespace Database\Seeders;

use App\Models\Choice;
use App\Models\Poll;
use Illuminate\Database\Seeder;

class PollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Poll::factory(5)->has(Choice::factory()->count(
            rand(2, config('librepolls.choices.max_per_poll'))
        ))->create();
    }
}
