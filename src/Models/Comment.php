<?php


namespace Techlink\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Techlink\Blog\Traits\HasFactoryTrait;

class Comment extends Model
{
    use HasFactoryTrait;

    protected $table = 'comments';

    protected $fillable = [
      'description', 'status', 'user_id', 'parent_id', 'post_id'
    ];

    protected $hidden = [
      'commentable_id', 'commentable_type'
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class);
    }
}