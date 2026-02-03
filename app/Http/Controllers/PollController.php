<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\Http\Request;

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

        $poll = new Poll();
        $poll->title = $title;
        $poll->multiple_choices = $allowMultipleChoices;
        $poll->save();

        $filledChoices = [];
        foreach ($choices as $choice) {
            if ($choice) {
                $filledChoices[] = ["text" => $choice];
            }
        }

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
