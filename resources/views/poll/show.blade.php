@extends('master')

@section('content')
    <h1>{{ $poll->title }}</h1>
    @session('status')
    <p class="status-container">{{ session('status') }}</p>
    @endsession
    <form action="{{ route('storeVote', $poll->slug) }}" method="post">
        @csrf
        @foreach($choices as $choice)
            <div class="radio-checkbox-container">
                @if($poll->multiple_choices)
                    <input id="{{$choice->id}}" type="checkbox" name="choices[]" value="{{$choice->id}}">
                @else
                    <input id="{{$choice->id}}" type="radio" name="choices[]" value="{{$choice->id}}">
                @endif
                <label for="{{$choice->id}}">{{$choice->text}}</label>
            </div>
        @endforeach
        <button type="submit">Vote</button>
    </form>
    <p><a href="{{route('resultsPoll', $poll->slug)}}">See results</a></p>
    <p><a href="{{route('home')}}">Create a new poll</a></p>
@endsection
