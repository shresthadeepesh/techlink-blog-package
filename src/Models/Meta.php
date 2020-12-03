<?php


namespace Techlink\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    protected $fillable = [
      'title', 'description', 'keywords'
    ];

    public $timestamps = false;

    public function metaable()
    {
        return $this->morphTo();
    }
}