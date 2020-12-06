@extends('blog::layouts.master')

@section('title', "$post->title")

@push('meta')
    <x-blog-meta
            :title="$post->meta->title"
            :description="$post->meta->description"
            :keywords="$post->meta->keywords"
            image="$post->images->url ?? null"
            :url="url()->current()"
    />
@endpush

@section('content')
    <div class="container">
            <div class="shadow-lg">
                @if($post->images)
                    <div class="image">
                        <img src="{{ asset($post->images->url ?? null) }}" alt="{{ $post->title }}" class="h-80 w-full" />
                    </div>
                @endif
                    <div class="content p-5 space-y-5">
                        <h3 class="text-4xl font-display font-bold text-center">
                            {{ $post->title ?? 'This is the default post header.' }}
                        </h3>

                        <ul class="list-none space-x-1 text-primary text-center">
                            <li class="inline">Published: {{ $post->created_at->diffForHumans() }}</li>
                            <li class="inline">Updated: {{ $post->updated_at->diffForHumans() }}</li>
                            <li class="inline"><a href="#0" class="">{{ $post->users->name }}</a></li>
                        </ul>

                        <div class="body text-primary font-body text-lg leading-relaxed">
                            {{ $post->description ?? null }}
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection