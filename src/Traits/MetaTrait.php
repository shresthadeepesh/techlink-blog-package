<?php


namespace Techlink\Blog\Traits;


trait MetaTrait
{
    public static function bootMetaTrait()
    {
        static::deleted(function($model) {
            if($model->meta) {
                $model->meta->delete();
            }
        });
    }
}