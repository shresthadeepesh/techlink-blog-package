<?php

namespace Techlink\Blog\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Techlink\Blog\Http\Interfaces\PostInterface;
use Techlink\Blog\Http\Requests\PostRequest;
use Techlink\Blog\Models\Category;
use Techlink\Blog\Models\Post;
use Techlink\Blog\Services\BlogService;

class AuthPostController extends Controller implements PostInterface
{
    private $modelName = 'posts';

    private $service;

    public function __construct(BlogService $service)
    {
        $this->service = $service;
    }

    /**
     * Index Post view
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $posts = Post::with('users', 'categories', 'images', 'meta')
            ->withCount('comments')
            ->latest()
            ->paginate(config('blog.auth_model_paginate'));
        return view('blog::posts.auth-index', compact('posts'));
    }

    /**
     * @param Post $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Post $post)
    {
        $category = Category::all()->pluck('title', 'id');
        return view('blog::forms.create', [
            'model' => $post,
            'category' => $category,
            'modelName' => $this->modelName,
        ]);
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

            //storing image
            $this->service->addImage($request, $post);
            //adding meta
            $this->service->addMeta($request, $post);

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
        $category = Category::all()->pluck('title', 'id');
        return view('blog::forms.edit', [
            'model' => $post,
            'category' => $category,
            'modelName' => $this->modelName,
        ]);
    }

    /**
     * @param PostRequest $request
     * @param Post $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(PostRequest $request, Post $post)
    {
        DB::transaction(function() use ($request, $post) {
            $post->update([
                'title' => $request->title,
                'description' => $request->description,
                'type' => $request->type,
                'status' => $request->status,
            ]);

            //syncing category
            $post->categories()->sync($request->categories);

            //storing image
            $this->service->addImage($request, $post);
            //adding meta
            $this->service->addMeta($request, $post);
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
            $post->images()->delete();
            return redirect()->route('blog::posts.index')->with(config('blog.flash_variable'), 'Post has been deleted.');
        }

        return redirect()->back()->with(config('blog.flash_variable'), 'Something went wrong.');
    }

}