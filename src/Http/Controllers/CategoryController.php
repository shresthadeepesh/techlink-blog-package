<?php

namespace Techlink\Blog\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Techlink\Blog\Http\Requests\CategoryRequest;
use Techlink\Blog\Models\Category;

class CategoryController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('blog::categories.index', compact('categories'));
    }

    /**
     * @param Category $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Category $category)
    {
        return view('blog::categories.show', compact('category'));
    }

    /**
     * @param Category $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Category $category)
    {
        return view('blog::categories.create', compact('category'));
    }

    /**
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        Auth::user()->categories()->create($request->all());
        return redirect()->route('blog::categories.index')->with(config('blog.flash_variable'), 'Category has been created.');
    }

    /**
     * @param Category $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Category $category)
    {
        return view('blog::categories.edit', compact('category'));
    }

    /**
     * @param Category $category
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Category $category, CategoryRequest $request)
    {
        $category->update($request->all());
        return redirect()->route('blog::categories.index')->with(config('blog.flash_variable'), 'Category has been updated.');
    }

    /**
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        if($category->delete()) {
            return redirect()->route('blog::categories.index')->with(config('blog.flash_variable'), 'Category has been deleted.');
        }
        return redirect()->back()->with(config('blog.flash_variable'), 'Something went wrong.');
    }
}