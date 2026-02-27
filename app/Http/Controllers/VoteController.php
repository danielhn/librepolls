<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVoteRequest;
use App\Models\Poll;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VoteController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVoteRequest $request, Poll $poll)
    {
        $choices = $request->validated('choices');

        $vote = new Vote();

        if ($poll->voter_identifier === 'ip') {
            $vote->voter_ip = $request->ip();
        } elseif ($poll->voter_identifier === 'token') {
            $vote->voter_token = Str::random(config('librepolls.votes.voter_token_length'));
        }

        $vote->poll()->associate($poll);
        $vote->save();
        $vote->choices()->attach($choices);

        if ($poll->voter_identifier === 'token') {
            return redirect()->route('resultsPoll', $poll->slug)
                ->with('status', 'Vote added successfully')
                ->cookie(cookie()->forever($poll->slug, $vote->voter_token));
        } else {
            return redirect()->route('resultsPoll', $poll->slug)
                ->with('status', 'Vote added successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Vote $vote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vote $vote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vote $vote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vote $vote)
    {
        //
    }
}
