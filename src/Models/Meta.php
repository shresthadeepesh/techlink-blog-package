<?php


namespace Techlink\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Techlink\Blog\Traits\HasFactoryTrait;

class Meta extends Model
{
    use HasFactoryTrait;

    protected $table = 'metas';

    protected $fillable = [
      'title', 'description', 'keywords'
    ];

    public $timestamps = false;

    public function metaable()
    {
        return $this->morphTo();
    }
}