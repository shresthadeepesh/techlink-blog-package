<?php

namespace Techlink\Blog\Traits;

use Illuminate\Support\Str;

trait SlugTrait
{
    public function path()
    {
        $path = explode('\\', __CLASS__);
        $a = Str::lower(array_pop($path));

        $plural = Str::plural(($a));

        return route("blog::{$plural}.show", [
            "$a" => $this->id,
            'slug' => Str::slug($this->title)
        ]);
    }
}