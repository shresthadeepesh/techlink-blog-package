<?php

namespace Techlink\Blog\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $post = DB::transaction(function() use ($request) {
            $post = Auth::user()->posts()->create([
                'title' => $request->title,
                'description' => $request->description,
                'type' => $request->type,
                'status' => $request->status,
            ]);

            $post->categories()->sync($request->categories);

            return $post;
        });

        return redirect($post->path())->with(config('blog.flash_variable'), 'Post has been created.');
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
        DB::transaction(function() use ($request, $post) {
            $post->update([
                'title' => $request->title,
                'description' => $request->description,
                'type' => $request->type,
                'status' => $request->status,
            ]);

            $post->categories()->sync($request->categories);
        });

        return redirect($post->path())->with(config('blog.flash_variable'), 'Post has been updated.');
    }

    /**
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Post $post)
    {
        if($post->delete()) {
            return redirect()->route('blog::posts.index')->with(config('blog.flash_variable'), 'Post has been deleted.');
        }

        return redirect()->back()->with(config('blog.flash_variable'), 'Something went wrong.');
    }

}