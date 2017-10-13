@extends('layouts.app')

@section('header')
    <link href="{{ mix('/css/main.css') }}" rel="stylesheet"></link>
@endsection

@section('content')
    <header>
        @include('pages.main.nav')
        <carousel>
            <div class="item"><img src="/images/carousel-team.jpg"   alt="Team"></div>
            <div class="item"><img src="/images/carousel-mike.jpg"   alt="Mike"></div>
            <div class="item"><img src="/images/carousel-ceila.jpg"  alt="Ceila"></div>
            <div class="item"><img src="/images/carousel-sulley.jpg" alt="Sulley"></div>
        </carousel>
    </header>

    <main class="main">
        @include('pages.main.mission')
        @include('pages.main.services')
        @include('pages.main.staff')
        @include('pages.main.customers')
        @include('pages.main.contacts')
    </main>

    <footer id="footer">
        <p>2016-2017, <a href="http://m-lab.xyz">Monster Lab.</a></p>
    </footer>
@endsection

@section('footer')
    <script src="/js/main.js"></script>
@endsection
