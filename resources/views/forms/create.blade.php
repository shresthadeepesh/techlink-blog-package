@extends('blog::layouts.master')

@section('title', 'Create ' . Str::singular(Str::title($modelName)))

@section('content')
    <div class="container">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route("blog::{$modelName}.auth.store") }}" method="POST">
                    @method('POST')
                    @csrf
                    @include("blog::{$modelName}.form")
                </form>
            </div>
        </div>
    </div>
@endsection