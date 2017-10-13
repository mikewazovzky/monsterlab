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
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <!-- TEMPORARY -->
    <style>
        body { margin-bottom: 50px; }
        .center { text-align: center; }
        .terms { padding-left: 20px; }
        .terms li { list-style: none; display: inline; }
        .terms li:after { content: " | "; }
        .terms li:last-child:after { content: none; }
        .tags { padding-left: 0; display: inline; }
        .tags li { list-style: none; display: inline; }
        .tags li:after { content: " | "; }
        .tags li:last-child:after { content: none; }
        .panel { margin: 7px 0; }
        .level { display: flex; align-items: center; }
        .flex { flex: 1; }
        .mr-1 { margin-right: 1em; }
        .mt-1 { margin-top: 1em; }
    </style>
    <!-- Pass data to JavaScript -->
    <script>
        window.App = {!! json_encode([
            'user' => Auth::user(),
            'signedIn' => Auth::check()
        ]) !!};
    </script>
    @yield('header')
</head>
<body>
    <div id="app">
        @yield('content')
        @include('layouts.nav')
        <flash :message="{{ json_encode(session('flash')) }}"></flash>
    </div>

    <!-- Scripts -->
    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('/js/app.js') }}"></script>
    @yield('footer')
</body>
</html>
