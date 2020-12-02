@extends('blog::layouts.master')

@section('title', 'Edit Post | Blog')

@section('content')
    <div class="container">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route("blog::{$modelName}.update", $model->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    @include("blog::{$modelName}.form")
                </form>
            </div>
        </div>
    </div>
@endsection