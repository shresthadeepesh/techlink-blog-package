<?php


namespace Techlink\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Techlink\Blog\Traits\HasFactoryTrait;
use Techlink\Blog\Traits\SlugTrait;

class Post extends Model
{
    use HasFactoryTrait, SlugTrait;

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
        return $this->belongsTo(User::class);
    }

//    protected static function booted()
//    {
//        static::created(function ($post) {
//            $post->user_id = auth()->user()->id;
//        });
//    }
}