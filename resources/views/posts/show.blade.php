@extends('app.layout')

@section('content')
    <h2>{{ $post->title }}</h2>
    <hr>
    <ul>
        @if(count($comments))
            @foreach($comments as $comment)
                <li>{{ $comment->text }}</li>
            @endforeach
        @endif
    </ul>


    @auth
        <form action="{{ route('posts.show', $post->id) }}" method="POST">
            <label for="text"></label><textarea name="text" id="text" cols="30" rows="10"></textarea>
        </form>
    @endauth
@endsection
