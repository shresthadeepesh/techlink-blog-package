<?php


namespace Techlink\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'url'
    ];

    public $timestamps = false;

    public function imageable()
    {
        return $this->morphTo();
    }
}