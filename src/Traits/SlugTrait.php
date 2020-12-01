<?php

namespace Techlink\Blog\Traits;

use Illuminate\Support\Str;

trait SlugTrait
{
    public function path()
    {
        return route('blog::posts.show', [
            'post' => $this->id,
            'slug' => Str::slug($this->title)
        ]);
    }
}