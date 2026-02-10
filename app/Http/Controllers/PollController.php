<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Validator;

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
        $password = $request->string('password');

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
            'title' => ['string', 'max:255', 'required'],
            'description' => ['string', 'max:1023', 'nullable'],
            'password' => ['string', 'min:4', 'max:63', 'nullable'],
            'multiple-choices' => ['boolean'],
            'voter-identifier' => ['in:ip,token,none', 'required'],
            'choices' => ['array','required', 'max:10'],
            'choices.1.text' => ['required'],
            'choices.2.text' => ['required'],
            'choices.*.text' => ['nullable', 'max:127', 'string']
        ]);

        $poll = new Poll();
        $poll->title = $title;
        $poll->multiple_choices = $allowMultipleChoices;
        $poll->slug = Str::random(8);
        $poll->description = $description;
        $poll->password = Hash::make($password);
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
