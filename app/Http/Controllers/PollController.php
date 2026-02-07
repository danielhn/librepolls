<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\Http\Request;
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
        $allowMultipleChoices = $request->boolean('multiple-choices');
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
            'multiple-choices' => ['sometimes', 'boolean'],
            'choices' => ['array','required', 'max:10'],
            'choices.1.text' => ['required'],
            'choices.2.text' => ['required'],
            'choices.*.text' => ['nullable', 'max:127', 'string']
        ]);

        $poll = new Poll();
        $poll->title = $title;
        $poll->multiple_choices = $allowMultipleChoices;
        $poll->save();

        $poll->choices()->createMany($filledChoices);

        return redirect()->route('home')->with('status', 'Poll created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
