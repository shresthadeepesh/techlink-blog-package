@extends('blog::layouts.master')

@section('title', "$category->title | Category")

@push('meta')
    <x-blog-meta
        :title="$category->meta->title"
        :description="$category->meta->description"
        :keywords="$category->meta->keywords"
        image="$category->images->url ?? null"
        :url="url()->current()"
    />
@endpush

@section('content')
    <div class="container">
        <div class="content text-center">
            <h3 class="">{{ $category->title }}</h3>
            <p class="lead">{{ $category->description }}</p>
        </div>
        <div class="row">
            @forelse($category->posts as $post)
                <x-blog-post-block :post="$post" />
            @empty
                <h3 class="">No posts found.</h3>
            @endforelse
        </div>
    </div>
@endsection