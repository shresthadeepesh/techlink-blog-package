<?php

namespace Techlink\Blog\View\Components;

use Illuminate\View\Component;

class Meta extends Component
{
    private $title, $description, $keywords, $url, $image;

    public function __construct($title, $description, $keywords, $url, $image)
    {
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
        $this->url = $url;
        $this->image = $image;
    }

    public function render()
    {
        return view('blog::components.meta', [
            'title' => $this->title,
            'description' => $this->description,
            'keywords' => $this->keywords,
            'url' => $this->url,
            'image' => $this->image
        ]);
    }
}