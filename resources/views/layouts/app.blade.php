<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- TEMPORARY -->
    <style>
        body { margin-bottom: 50px; }
        .center { text-align: center; }
        .sidebar li { list-style: none; display: inline; }
        .sidebar li:after { content: " | "; }
        .sidebar li:last-child:after { content: none; }
        .panel { margin: 7px 0; }
        .level { display: flex; align-items: center; }
        .flex { flex: 1; }
    </style>
    @yield('header')
</head>
<body>
    <div>
        @include('layouts.nav')
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('footer')
</body>
</html>
