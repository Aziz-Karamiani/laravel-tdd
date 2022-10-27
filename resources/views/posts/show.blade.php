@extends('app.layout')

@section('content')
    <h2>{{ $post->title }}</h2>
    <hr>
    <ul>
        @foreach($comments as $comment)
            <li>{{ $comment->text }}</li>
        @endforeach
    </ul>
@endsection
