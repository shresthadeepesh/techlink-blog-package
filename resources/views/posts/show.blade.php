@extends('blog::layouts.master')

@section('title', "$post->title | Blog")

@section('content')
    <div class="container">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="">
                        {{ $post->title ?? 'This is the default post header.' }}
                    </h3>
                    <p class="lead">{{ $post->description ?? null }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection