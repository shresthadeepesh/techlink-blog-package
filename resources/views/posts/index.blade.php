@extends('blog::layouts.master')

@section('title', 'Post Index')

@section('content')
    <div class="container">
        <div class="flex flex-wrap">
            @forelse($posts as $post)
                <x-blog-post-block :post="$post" />
            @empty
                <h3 class="text-2xl text-center">No posts found!</h3>
            @endforelse
        </div>
        <div class="mx-auto">
            {{ $posts->links() }}
        </div>
    </div>
@endsection