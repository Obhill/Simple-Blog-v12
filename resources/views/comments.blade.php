<!-- resources/views/posts/comments.blade.php -->

@extends('layouts.app')

@section('content')

    <h1>{{ $user->name }}'s Comments</h1>

    @foreach ($comments as $singleComment)

        <div class="comment">
            <p>{{ $singleComment->content }}</p>
            <p>Posted on: {{ $singleComment->created_at }}</p>
            <p>On Post: <a href="{{ route('posts.show', $singleComment->post) }}">{{ $singleComment->post->title }}</a></p>
        </div>

    @endforeach

    {{ $comments->links() }}

@endsection
