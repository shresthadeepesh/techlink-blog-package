<?php


namespace Techlink\Blog\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Techlink\Blog\Http\Requests\CommentRequest;
use Techlink\Blog\Models\Comment;
use Techlink\Blog\Models\Post;

class AuthCommentController extends Controller
{
    private $modelName = 'comments';

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $comments = Comment::with('users')->latest()
            ->paginate(config('blog.auth_model_paginate'));
        return view('blog::comments.auth-index', compact('comments'));
    }

    /**
     * @param Post $post
     * @param CommentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Post $post, CommentRequest $request)
    {
        $post->comments()->create([
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'status' => false,
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->back()->with(config('blog.flash_variable'), 'Comment has been created.');
    }

    /**
     * @param Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Comment $comment)
    {
        if($comment->delete()) {
            return redirect()->route('blog::comments.auth.index')->with(config('blog.flash_variable'), 'Comment has been deleted.');
        }
        return redirect()->back()->with(config('blog.flash_variable'), 'Something went wrong.');
    }
}