<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Canvato - Digital Atelier')</title>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('canvato/assets/css/style.css') }}">
    @yield('page-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body @yield('body-class')>

    @yield('content')

    @yield('page-scripts')
</body>
</html>
