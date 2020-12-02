<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('vendor/techlink/blog/css/bootstrap.min.css') }}">
    <style>
        .invalid-feedback {
            display: block;
        }
    </style>
</head>
<body>
    <x-blog-alert></x-blog-alert>

    @yield('content')
</body>
</html>