@extends('blog::layouts.master')

@section('title', 'Create ' . Str::singular(Str::title($modelName)))

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/techlink/blog/css/select2.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('vendor/techlink/blog/js/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/techlink/blog/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select-multiple').select2();
        });
    </script>
@endpush

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