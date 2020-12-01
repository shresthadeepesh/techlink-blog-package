<?php

namespace Techlink\Blog\Traits;

use Techlink\Blog\Models\Post;

trait UserRelationTrait
{
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}