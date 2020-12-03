<?php

namespace Techlink\Blog\Services;

use Illuminate\Support\Str;

class BlogService
{
    public function addImage($request, $model) :void
    {
        //if upload image is available
        if($request->file('image')) {
            //uploading new image
            $path = $request->file('image')->store('public/images');
            //inserting the path to db
            $model->images()->updateOrCreate([
                'id' => $model->images->id ?? null,
            ], [
                'url' => Str::replaceFirst('public', 'storage', $path)
            ]);
        }
    }

    public function addMeta($request, $model) :void
    {
        $model->meta()->updateOrCreate([
            'id' => $model->meta->id ?? null,
        ], [
            'title' => $request->meta_title,
            'description' => $request->meta_description,
            'keywords' => $request->meta_keywords
        ]);
    }
}