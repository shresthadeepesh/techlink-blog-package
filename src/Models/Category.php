<?php

namespace Techlink\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Techlink\Blog\Traits\HasFactoryTrait;
use Techlink\Blog\Traits\ImageTrait;
use Techlink\Blog\Traits\MetaTrait;
use Techlink\Blog\Traits\SlugTrait;

class Category extends Model
{
    use HasFactoryTrait, SlugTrait, ImageTrait, MetaTrait;

    protected $fillable = [
        'title', 'description', 'user_id'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     * attaching image relation
     */
    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * attaching meta relation
     */
    public function meta()
    {
        return $this->morphOne(Meta::class, 'metaable');
    }
}