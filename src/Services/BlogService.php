<?php

namespace Techlink\Blog\Services;

class BlogService
{
    public function addImage($request, $model) :void
    {
        //if upload image is available
        if($request->file('image')) {
            //uploading new image
            $path = $request->file('image')->store('images');
            $model->images()->updateOrCreate([
                'id' => $model->images->id ?? null,
            ], [
                'url' => $path
            ]);
        }
    }
}