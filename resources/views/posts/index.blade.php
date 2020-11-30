@extends('blog::layouts.master')

@section('title', 'Blog | Index')

@section('content')
    <div class="container">
        <div class="row">
            @if(isset($posts) && $posts->count() > 0)
                @foreach($posts as $post)
                    <div class="col-md-4">
                        <div class="card shadow">
                            <div class="card-body">
                                <h3 class="">
                                    <a href="{{ route('techlink.blog.posts.show',  ['post' => $post->id]) }}">{{ $post->title ?? 'This is the default post header.' }}</a>
                                </h3>
                                <p class="lead">{{ $post->description ?? null }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="mr-auto">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection