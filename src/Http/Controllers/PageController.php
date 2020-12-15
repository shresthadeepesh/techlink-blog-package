<?php


namespace Techlink\Blog\Http\Controllers;

use Illuminate\Routing\Controller;
use Techlink\Blog\Models\Post;

class PageController extends Controller
{
    public function __invoke($page)
    {
        if(view()->exists("blog::pages.{$page}")) {
            return view("blog::pages.{$page}");
        }

        $post = Post::page()->ofStatus(Post::$published)->with('users', 'meta', 'image')
            ->firstOrFail();
        return view('blog::posts.show', compact('post'));
    }
}