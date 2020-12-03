<?php

namespace Techlink\Blog\Traits;

use Techlink\Blog\Models\Category;
use Techlink\Blog\Models\Post;

trait BlogUserTrait
{
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}