<?php


namespace Techlink\Blog\Http\Controllers;

use Illuminate\Routing\Controller;
use Techlink\Blog\Models\Category;

class CategoryController extends Controller
{
    /**
     * @param Category $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Category $category)
    {
        return view('blog::categories.show', compact('category'));
    }
}