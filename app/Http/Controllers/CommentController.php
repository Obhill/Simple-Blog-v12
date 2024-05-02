<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $comment = new Comment(['content' => $request->input('content')]);
        $comment->user()->associate(Auth::user());
        $comment->post()->associate($post);

        if (empty($post->id)) {
            \Log::error("Post ID is missing");
            abort(500, "Post ID is missing");
        }

        $comment->save();
        return redirect()->route('posts.show', $post)->with('success', 'Comment added successfully.');
    }

    public function destroy(Post $post, Comment $comment)
    {
        if (!Gate::allows('delete-comment', $comment)) {
            return redirect()->route('posts.show', ['post' => $post])->with('error', 'You are not authorized to delete this comment.');
        }

        try {
            $comment->delete();
            return redirect()->route('posts.show', ['post' => $post])->with('success', 'Comment deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Failed to delete comment: ' . $e->getMessage());
            return redirect()->route('posts.show', ['post' => $post])->with('error', 'Failed to delete the comment.');
        }
    }

    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);
        return view('editcomment', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        dd($comment);
        $this->authorize('update', $comment);

        $request->validate([
            'content' => 'required|string',
        ]);

        $comment->update(['content' => $request->input('content')]);
        return redirect()->route('posts.show', $comment->post)->with('success', 'Comment updated successfully.');
    }

    public function like(Comment $comment)
    {
        auth()->user()->likedComments()->toggle($comment->id);
        return back();
    }
}
