<?php

namespace Techlink\Blog\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Techlink\Blog\Http\Interfaces\CategoryInterface;
use Techlink\Blog\Http\Requests\CategoryRequest;
use Techlink\Blog\Models\Category;
use Techlink\Blog\Services\BlogService;

class AuthCategoryController extends Controller implements CategoryInterface
{
    private $modelName = 'categories';

    private $service;

    public function __construct(BlogService $service)
    {
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $categories = Category::latest()
            ->withCount('posts')
            ->paginate(config('blog.auth_model_paginate'));
        return view('blog::categories.auth-index', compact('categories'));
    }

    /**
     * @param Category $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Category $category)
    {
        return view('blog::forms.create', [
            'model' => $category,
            'modelName' => $this->modelName
        ]);
    }

    /**
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        $category = Auth::user()->categories()->create($request->all());

        //storing image
        $this->service->addImage($request, $category);

        //adding meta
        $this->service->addMeta($request, $category);

        return redirect()->route('blog::categories.auth.index')->with(config('blog.flash_variable'), 'Category has been created.');
    }

    /**
     * @param Category $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Category $category)
    {
        return view('blog::forms.edit', [
            'model' => $category,
            'modelName' => $this->modelName
        ]);
    }

    /**
     * @param Category $category
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->all());

        //storing image
        $this->service->addImage($request, $category);
        //adding meta
        $this->service->addMeta($request, $category);

        return redirect()->route('blog::categories.auth.index')->with(config('blog.flash_variable'), 'Category has been updated.');
    }

    /**
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        if($category->delete()) {
            $category->images()->delete();
            return redirect()->route('blog::categories.auth.index')->with(config('blog.flash_variable'), 'Category has been deleted.');
        }
        return redirect()->back()->with(config('blog.flash_variable'), 'Something went wrong.');
    }
}