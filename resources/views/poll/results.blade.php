@extends('master')

@section('content')
    @session('status')
    <p class="status-container">{{ session('status') }}</p>
    @endsession
    <h1>Results for: {{$title}}</h1>
    <p>{{$description}}</p>
    <ol>
        @foreach($results as $choice => $votes)
            <li>{{$choice}} - {{$votes}}</li>
        @endforeach
    </ol>
    <p><b>Total votes: {{$totalVotes}}</b></p>
    <p><a href="{{route('home')}}">Create a new poll</a></p>
@endsection
