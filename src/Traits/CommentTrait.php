<?php

namespace Techlink\Blog\Traits;

trait CommentTrait
{
    public static function bootCommentTrait()
    {
        static::deleted(function($model) {
            if($model->comments) {
                $model->comments()->delete();
            }
        });
    }
}