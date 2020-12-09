<?php


namespace Techlink\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Techlink\Blog\Traits\CommentTrait;
use Techlink\Blog\Traits\HasFactoryTrait;
use Techlink\Blog\Traits\ImageTrait;
use Techlink\Blog\Traits\MetaTrait;
use Techlink\Blog\Traits\SlugTrait;

class Post extends Model
{
    use HasFactoryTrait, SlugTrait, ImageTrait, MetaTrait, CommentTrait;

    protected $table = 'posts';

    protected $fillable = [
        'title', 'description', 'status', 'type', 'user_id'
    ];

    public static $published = 1;
    public static $draft = 0;

    public function scopeOfStatus($query, bool $status)
    {
        return $query->where('status', $status);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_post');
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

    /**
     * attaching post comments
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}