@extends('blog::layouts.master')

@section('title', 'Create Post | Blog')

@section('content')
    <div class="container">
        <div class="card shadow">
            <form action="{{ route('blog::posts.store') }}" method="POST">
                @method('POST')
                @include('blog::posts.form')
            </form>
        </div>
    </div>
@endsection