<?php


namespace Techlink\Blog\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryPost extends Pivot
{
    protected $table = 'category_post';
}