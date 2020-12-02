<?php

namespace Techlink\Blog\View\Components;

use Illuminate\View\Component;

class PostBlock extends Component
{
    private $post;

    public function __construct($post)
    {
        $this->post = $post;
    }

    public function render()
    {
        return view('blog::components.post-block', [
            'post' => $this->post
        ]);
    }
}