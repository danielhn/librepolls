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
            <label for="description">Description</label>
            <textarea id="description" name="description" maxlength="1023" cols="30" rows="10">
                {{old('description')}}
            </textarea>
        </div>
        <div>
            <label for="choice-1">Choice 1</label>
            <input type="text" id="choice-1" name="choices[1][text]" value="{{ old('choices.1.text')}}" maxlength="127" required>
        </div>
        <div>
            <label for="choice-2">Choice 2</label>
            <input type="text" id="choice-2" name="choices[2][text]" value="{{ old('choices.2.text') }}" maxlength="127" required>
        </div>
        @for ($i = 3; $i <= 10; $i++)
            <div>
                <label for="choice-{{$i}}">Choice {{$i}}</label>
                <input type="text" id="choice-{{$i}}" name="choices[{{$i}}][text]" value="{{ old('choices.' . $i . '.text') }}" maxlength="127">
            </div>
        @endfor
        <div>
            <label for="multiple-choices">Allow selection of multiple choices?</label>
            <input type="checkbox" @if(old('multiple-choices') == 'on') checked="checked" @endif name="multiple-choices" id="multiple-choices">
        </div>
        <div>
            <label for="voter-identifier">Vote restrictions</label>
            <select name="voter-identifier" id="voter-identifier">
                <option value="ip">Allow one vote per IP address</option>
                <option value="token">Allow one vote per web browser</option>
                <option value="none">Anyone can vote many times, no restrictions</option>
            </select>
        </div>
        <button type="submit">Create poll</button>
    </form>
@endsection
