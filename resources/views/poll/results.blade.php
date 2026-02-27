@extends('master')

@section('content')
    @session('status')
    <p>{{ session('status') }}</p>
    @endsession
    <h1>Results for {{$title}}</h1>
    <p>{{$description}}</p>
    <ol>
        @foreach($results as $choice => $votes)
            <li>{{$choice}} - {{$votes}}</li>
        @endforeach
    </ol>
    <p>Total votes: {{$totalVotes}}</p>
    <p><a href="{{route('home')}}">Create a new poll</a></p>
@endsection
