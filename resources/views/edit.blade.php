<!-- resources/views/posts/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Edit Post</h1>
    
    @can('update-post', $post)
        <form action="{{ route('posts.update', $post) }}" method="POST">
            @csrf
            @method('PATCH')

            <label for="title">Title:</label>
            <input type="text" name="title" id="title" value="{{ $post->title }}" required>

            <label for="content">Content:</label>
            <textarea name="content" id="content" cols="30" rows="10" required>{{ $post->content}}</textarea>

            <button type="submit">Update Post</button>
        </form>
    @else
        <p>You do not have permission to edit posts</p>
    @endcan 
@endsection