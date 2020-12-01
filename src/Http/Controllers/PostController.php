<?php

namespace Techlink\Blog\Http\Controllers;

use Illuminate\Routing\Controller;
use Techlink\Blog\Http\Requests\PostRequest;
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
            ->firstOrFail();
        return view('blog::posts.show', compact('post'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Post $post)
    {
        return view('blog::posts.create', compact('post'));
    }

    /**
     * @param PostRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostRequest $request)
    {
        $post = Post::create($request->all());
        return redirect($post->path())->with('message', 'Post has been created.');
    }

    /**
     * @param Post $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Post $post)
    {
        return view('blog::posts.edit', compact('post'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $post->update($request->all());
        return redirect($post->path())->with('message', 'Post has been updated.');
    }

    /**
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Post $post)
    {
        if($post->delete()) {
            return redirect()->route('blog::posts.index')->with('message', 'Post has been deleted.');
        }
    }

}