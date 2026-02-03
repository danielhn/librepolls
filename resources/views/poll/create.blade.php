<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Create a new poll</h1>
    @session('status')
    <p> {{ $value }} </p>
    @endsession
    <form action="{{ route('storePoll') }}" method="post">
        @csrf
        <div>
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div>
            <label for="choice-1">Choice 1</label>
            <input type="text" id="choice-1" name="choices[1]" required>
        </div>
        <div>
            <label for="choice-2">Choice 2</label>
            <input type="text" id="choice-2" name="choices[2]" required>
        </div>
        @for ($i = 3; $i <= 10; $i++)
            <div>
                <label for="choice-{{$i}}">Choice {{$i}}</label>
                <input type="text" id="choice-{{$i}}" name="choices[{{$i}}]">
            </div>
        @endfor
        <div>
            <label for="multiple-choices">Allow selection of multiple choices?</label>
            <input type="checkbox" name="multiple-choices" id="multiple-choices">
        </div>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
