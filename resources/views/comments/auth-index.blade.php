@extends('blog::layouts.master')

@section('title', 'Comments Index')

@section('content')
    <x-blog-model-table
            title="Comments Index"
            description="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab accusamus alias culpa cum eaque id itaque laboriosam omnis soluta voluptatum."
            :fillables="[
                    'user' => 'users',
                    'description' => 'description',
                    'date' => 'created_at'
                ]"
            :models="$comments"
            type="comments"
    />
@endsection