<!DOCTYPE html>
<html lang="en">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="tendR">
    <meta name="author" content="TallmanCode">
    <meta name="keyword" content="">
    <title>tendR</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('media/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('media/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('media/favicons/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('media/favicons/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffc40d">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('template-css')
</head>
<body class="tm-app">
    <div id="app">
        @yield('body')
    </div>
</body>
    @yield('template-js')
</html>
