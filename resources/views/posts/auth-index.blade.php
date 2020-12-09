@extends('blog::layouts.master')

@section('title', 'Posts Index')

@section('content')
    <x-blog-model-table
            title="Posts Index"
            description="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab accusamus alias culpa cum eaque id itaque laboriosam omnis soluta voluptatum."
            :fillables="[
                    'title' => 'title',
                    'image' => 'images',
                    'description' => 'description',
                    'user' => 'users',
                    'keywords' => 'meta',
                    'date' => 'created_at'
                ]"
            :models="$posts"
            type="posts"
    />
@endsection