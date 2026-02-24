<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePollRequest;
use App\Models\Poll;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('poll.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePollRequest $request)
    {
        $title = $request->safe()->string('title');
        $description = $request->safe()->string('description');

        $allowMultipleChoices = $request->safe()->boolean('multiple-choices');

        $voterIdentifier = $request->safe()->string('voter-identifier');
        $filledChoices = $request->safe()->array('choices');

        $poll = new Poll();
        $poll->title = $title;
        $poll->multiple_choices = $allowMultipleChoices;
        $poll->slug = Str::random(config('librepolls.polls.slug_length'));
        $poll->description = $description;
        $poll->voter_identifier = $voterIdentifier;
        $poll->save();

        $poll->choices()->createMany($filledChoices);

        return redirect()->route('home')
            ->with('status', 'Poll created successfully.')
            ->with('pollURL', route('showPoll', $poll->slug));
    }

    /**
     * Display the specified resource.
     */
    public function show(Poll $poll)
    {
        $pollChoices = $poll->choices()->get();

        return view('poll.show', [
            'poll' => $poll, 'choices' => $pollChoices,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
