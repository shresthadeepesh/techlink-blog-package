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
    public function show($category)
    {
        $category = Category::with(['posts' => function($post) {
            return $post->with('images');
        },
        'meta'
        ])->findOrFail($category);
        return view('blog::categories.show', compact('category'));
    }
}