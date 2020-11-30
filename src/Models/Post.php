<?php


namespace Techlink\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Techlink\Blog\Traits\HasFactoryTrait;

class Post extends Model
{
    use HasFactoryTrait;

    protected $fillable = [
        'title', 'description', 'status', 'type',
    ];

    public static $published = 1;
    public static $draft = 0;

    public function scopeOfStatus($query, bool $status)
    {
        return $query->where('status', $status);
    }
}