<?php

namespace Techlink\Blog\Traits;

use Techlink\Blog\Models\Category;
use Techlink\Blog\Models\Comment;
use Techlink\Blog\Models\Post;

trait BlogUserTrait
{
    /**
     * Relation for posts
     * @return mixed
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Relation for categories
     * @return mixed
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Relation for comments
     * @return mixed
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}