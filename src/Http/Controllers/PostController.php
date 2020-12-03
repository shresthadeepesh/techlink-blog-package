<?php

namespace Techlink\Blog\Http\Controllers;

use Illuminate\Routing\Controller;
use Techlink\Blog\Models\Post;

class PostController extends Controller
{
    /**
     * Index Post view
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $posts = Post::ofStatus(Post::$published)
            ->with('users', 'categories', 'images')
            ->latest()
            ->paginate(5);
        return view('blog::posts.index', compact('posts'));
    }

    /**
     * Single Post view
     * @param Post $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($post)
    {
        $post = Post::ofStatus(Post::$published)
            ->with('users', 'categories', 'images', 'meta')
            ->findOrFail($post);
        return view('blog::posts.show', compact('post'));
    }
}