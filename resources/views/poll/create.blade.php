@extends('master')

@section('content')
    @session('status')
        <p>{{ session('status') }}</p>
    @endsession
    @session('pollURL')
        <p>The link for your new poll is <a href="{{ session('pollURL') }}">{{ session('pollURL') }}</a></p>
    @endsession
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <h1>Create a new poll</h1>
    <form action="{{ route('storePoll') }}" method="post">
        @csrf
        <div>
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}"
                   maxlength="{{ config('librepolls.polls.title_max_length') }}" required>
        </div>
        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description"
                      maxlength="{{config('librepolls.polls.description_max_length')}}"
                      cols="30" rows="10">{{old('description')}}</textarea>
        </div>
        <div>
            <label for="choice-1">Choice 1</label>
            <input type="text" id="choice-1" name="choices[1][text]" value="{{ old('choices.1.text')}}"
                   maxlength="{{config('librepolls.choices.max_text_length')}}" required>
        </div>
        <div>
            <label for="choice-2">Choice 2</label>
            <input type="text" id="choice-2" name="choices[2][text]" value="{{ old('choices.2.text') }}"
                   maxlength="{{config('librepolls.choices.max_text_length')}}" required>
        </div>
        @for ($i = 3; $i <= config('librepolls.choices.max_per_poll'); $i++)
            <div>
                <label for="choice-{{$i}}">Choice {{$i}}</label>
                <input type="text" id="choice-{{$i}}" name="choices[{{$i}}][text]" value="{{ old('choices.' . $i . '.text') }}"
                       maxlength="{{config('librepolls.choices.max_text_length')}}">
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
