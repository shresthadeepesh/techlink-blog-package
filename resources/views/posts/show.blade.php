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
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="image">
                        <img src="{{ asset($post->images->url ?? null) }}" alt="{{ $post->title }}" class="img-fluid" />
                    </div>
                    <div class="content">
                        <h3 class="">
                            {{ $post->title ?? 'This is the default post header.' }}
                        </h3>
                        <p class="lead">{{ $post->description ?? null }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection