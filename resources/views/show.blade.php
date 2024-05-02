@extends('layouts.app')

@section('content')
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>
    <p>Views: {{ $post->views }}</p>
    <p>Posted by: {{ $post->user->name }}</p>

    @if(auth()->user()->isAdmin())
        <form action="{{ route('posts.destroy', $post) }}" method="POST" style="margin-bottom: 20px;">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-button">Delete Post</button>
        </form>
    @endif

    <h2>Add a comment</h2>
    <form action="{{ route('comments.store', $post) }}" method="POST">
        @csrf
        <label for="content">Comment:</label>
        <textarea name="content" id="content" cols="30" rows="5" required></textarea>
        <button type="submit">Add Comment</button>
    </form>

    <h2>Comments</h2>
    @foreach ($post->comments as $comment)
        <div class="comment" id="comment_{{ $comment->id }}">
            <p>{{ $comment->content }}</p>
            <p>Comment by: <a href="{{ route('users.comments', $comment->user) }}">{{ $comment->user->name }}</a></p>
            <p>Likes: <span id="likesCount_{{ $comment->id }}">{{ $comment->likes->count() }}</span></p>
            <form action="{{ route('comments.like', $comment) }}" method="POST" id="likeForm_{{ $comment->id }}">
                @csrf
                <button type="submit" id="likeButton_{{ $comment->id }}">Like</button>
            </form>
            @can('delete', $comment)
                <form action="{{ route('comments.destroy', ['post' => $post, 'comment' => $comment]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-button">Delete Comment</button>
                </form>
            @else
                @if(auth()->user()->isAdmin())
                    <form action="{{ route('comments.destroy', ['post' => $post, 'comment' => $comment]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-button">Delete Comment</button>
                    </form>
                @endif
            @endcan
        </div>
    @endforeach
@endsection