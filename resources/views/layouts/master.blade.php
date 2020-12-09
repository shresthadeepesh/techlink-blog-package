<!doctype html>
<html lang="en">
<head>
    <!--- meta tags
    ================================================== -->
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="index, follow">
    @stack('meta')

    <!--- title
    ================================================== -->
    <title>
        @hasSection('title')
            @yield('title') | Blog
        @else
            Techlink | Blog
        @endif
    </title>

    <!--- css and styles
    ================================================== -->
    <link rel="stylesheet" href="{{ asset('vendor/techlink/blog/css/style.css') }}">
    @stack('styles')
    <style>
        .invalid-feedback {
            display: block;
        }
    </style>
</head>
<body>
    <div class="my-10">
        <x-blog-alert></x-blog-alert>
        @yield('content')
    </div>

    <!--- js and scripts
    ================================================== -->
    @stack('scripts')
</body>
</html>