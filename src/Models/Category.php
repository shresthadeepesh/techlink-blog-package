<?php

namespace Techlink\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Techlink\Blog\Traits\HasFactoryTrait;
use Techlink\Blog\Traits\SlugTrait;

class Category extends Model
{
    use HasFactoryTrait, SlugTrait;

    protected $fillable = [
        'title', 'description', 'user_id'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}