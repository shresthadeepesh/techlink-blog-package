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
        <div class="content text-center space-y-5 my-5">
            <h3 class="text-5xl font-display font-bold">Category: {{ $category->title }}</h3>
            <p class="font-body text-primary text-xl">{{ $category->description }}</p>
        </div>
        <div class="flex flex-wrap">
            @forelse($category->posts as $post)
                <x-blog-post-block :post="$post" />
            @empty
                <h3 class="text-3xl font-display">No posts found.</h3>
            @endforelse
        </div>
    </div>
@endsection