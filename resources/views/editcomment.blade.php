<!-- resources/views/comments/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Edit Comment</h1>
    <form action="{{ route('comments.update', ['post' => $post, 'comment' => $comment]) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="content">Comment:</label>
        <textarea name="content" id="content" cols="30" rows="5" required>{{ $comment->content }}</textarea>
        <button type="submit">Update Comment</button>
    </form>
@endsection
