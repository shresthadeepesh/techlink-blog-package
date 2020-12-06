@extends('blog::layouts.master')

@section('title', 'Create ' . Str::singular(Str::title($modelName)))

@section('content')
    <div class="container">
        <div class="shadow-md hover:shadow-xl transition-hover duration-500 rounded-md">
            <div class="p-5">
                <form action="{{ route("blog::{$modelName}.auth.store") }}" method="POST" enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    @include("blog::{$modelName}.form")
                </form>
            </div>
        </div>
    </div>
@endsection