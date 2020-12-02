@extends('blog::layouts.master')

@section('title', 'Create Post | Blog')

@section('content')
    <div class="container">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('blog::posts.store') }}" method="POST">
                    @method('POST')
                    @csrf
                    @include('blog::posts.form')
                </form>
            </div>
        </div>
    </div>
@endsection