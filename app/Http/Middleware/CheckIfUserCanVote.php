<?php

namespace App\Http\Middleware;

use App\Models\Vote;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfUserCanVote
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $poll = $request->route('poll');

        if ($poll->voter_identifier === 'token') {
            $voterToken = $request->cookie($poll->slug);

            $vote = Vote::where('voter_token', $voterToken)
                ->where('poll_id', $poll->id)->first();

            if ($vote) {
                return redirect()->route('resultsPoll', $poll->slug);
            }
        } elseif ($poll->voter_identifier === 'ip') {
            $ip = $request->ip();

            $vote = Vote::where('voter_ip', $ip)
                ->where('poll_id', $poll->id)->first();

            if ($vote) {
                return redirect()->route('resultsPoll', $poll->slug);
            }
        }

        return $next($request);
    }
}
