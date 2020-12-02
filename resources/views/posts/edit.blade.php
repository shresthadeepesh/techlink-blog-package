@extends('blog::layouts.master')

@section('title', 'Edit Post | Blog')

@section('content')
    <div class="container">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('blog::posts.update', ['post' => $post->id]) }}" method="POST">
                    @method('PUT')
                    @csrf
                    @include('blog::posts.form')
                </form>
            </div>
        </div>
    </div>
@endsection