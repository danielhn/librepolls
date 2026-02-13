<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {
        $title = $request->string('title');
        $description = $request->string('description');

        $allowMultipleChoices = $request->boolean('multiple-choices');

        $voterIdentifier = $request->string('voter-identifier');
        $choices = $request->array('choices');

        // Remove unfilled fields, and any other unwanted key
        $filledChoices = [];
        foreach ($choices as $choice) {
            if ($choice['text']) {
                $filledChoices[] = ['text' => $choice['text']];
            }
        }

        $request->validate([
            'title' => ['string', 'max:' . config('librepolls.polls.title_max_length'), 'required'],
            'description' => ['string', 'max:' . config('librepolls.polls.description_max_length'), 'nullable'],
            'multiple-choices' => ['accepted', 'sometimes'],
            'voter-identifier' => ['in:ip,token,none', 'required'],
            'choices' => ['array','required', 'max:' . config('librepolls.choices.max_per_poll')],
            'choices.1.text' => ['required'],
            'choices.2.text' => ['required'],
            'choices.*.text' => ['nullable', 'max:' . config('librepolls.choices.max_text_length'), 'string']
        ]);

        $poll = new Poll();
        $poll->title = $title;
        $poll->multiple_choices = $allowMultipleChoices;
        $poll->slug = Str::random(config('librepolls.polls.slug_length'));
        $poll->description = $description;
        $poll->voter_identifier = $voterIdentifier;
        $poll->save();

        $poll->choices()->createMany($filledChoices);

        return redirect()->route('home')->with('status', 'Poll created successfully');
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
