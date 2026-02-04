@extends('master')

@section('content')
    <h1>Create a new poll</h1>
    @session('status')
    <p> {{ $value }} </p>
    @endsession
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <form action="{{ route('storePoll') }}" method="post">
        @csrf
        <div>
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" maxlength="255" required>
        </div>
        <div>
            <label for="choice-1">Choice 1</label>
            <input type="text" id="choice-1" name="choices[][text]" value="{{ old('choices.1.text')}}" maxlength="127" required>
        </div>
        <div>
            <label for="choice-2">Choice 2</label>
            <input type="text" id="choice-2" name="choices[][text]" value="{{ old('choices.2.text') }}" maxlength="127" required>
        </div>
        @for ($i = 3; $i <= 10; $i++)
            <div>
                <label for="choice-{{$i}}">Choice {{$i}}</label>
                <input type="text" id="choice-{{$i}}" name="choices[][text]" value="{{ old('choices.' . $i . '.text') }}" maxlength="127">
            </div>
        @endfor
        <div>
            <label for="multiple-choices">Allow selection of multiple choices?</label>
            <input type="checkbox" @if(old('multiple-choices') == 'on') checked="checked" @endif name="multiple-choices" id="multiple-choices">
        </div>
        <button type="submit">Submit</button>
    </form>
@endsection
