@extends('master')

@section('content')
    @session('status')
    <p class="status-container">{{ session('status') }}</p>
    @endsession
    <h1>Results for: {{$title}}</h1>
    <p>{{$description}}</p>
    <ol>
        @foreach($results as $choice => $votes)
            <li>
                <label for="option{{ $loop->iteration }}">{{ $choice }} ({{ $votes }} votes)</label>
                <meter id="option{{ $loop->iteration }}" max="{{ $totalVotes }}"
                       value="{{ $votes }}">{{ $votes }} votes
                </meter>
            </li>
        @endforeach
    </ol>
    <p><b>Total votes: {{$totalVotes}}</b></p>
    @if($showVoteLink)
        <p><a href="{{route('showPoll', $slug)}}">Vote in this poll</a></p>
    @endif
    <p><a href="{{route('home')}}">Create a new poll</a></p>
@endsection
