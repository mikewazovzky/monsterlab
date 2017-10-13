@extends('layouts.app')

@section('header')
    <link href="{{ mix('/css/main.css') }}" rel="stylesheet"></link>
@endsection

@section('content')
    <header>
        {{-- @include('pages.main.nav') --}}
        <main-menu>
            <template slot="menu-items">
                <li class="active"><a href="#featured">{{ __('Home') }}</a></li>
                <li><a href="#mission">{{ __('Mission') }}</a></li>
                <li><a href="#services">{{ __('Services') }}</a></li>
                <li><a href="#staff">{{ __('Staff') }}</a></li>
                <li><a href="#customers">{{ __('Customers') }}</a></li>
                <li><a href="#contacts">{{ __('Contacts') }}</a></li>
            </template>
            <template slot="extra-items">
                <li>
                    <a href="/main/{{ $locale }}">
                        <img src="/images/{{ $locale }}.png" title="{{ $locale == 'ru' ? 'English' : 'Русский' }}">
                    </a>
                </li>
            </template>
        </main-menu>

        <carousel>
            <div class="item"><img src="/images/carousel-team.jpg"   alt="Team"></div>
            <div class="item"><img src="/images/carousel-mike.jpg"   alt="Mike"></div>
            <div class="item"><img src="/images/carousel-ceila.jpg"  alt="Ceila"></div>
            <div class="item"><img src="/images/carousel-sulley.jpg" alt="Sulley"></div>
        </carousel>
    </header>

    <main class="main">
        <section class="section" id="mission">
            @include('pages.main.mission')
        </section>

        <section class="section" id="services">
            @include('pages.main.services')
        </section>

        <section class="section" id="staff">
            @include('pages.main.staff')
        </section>

        <section class="section" id="customers">
            @include('pages.main.customers')
        </section>

        <section class="section" id="contacts">
            @include('pages.main.contacts')
        </section>
    </main>

    <footer id="footer">
        <p>2016-2017, <a href="http://m-lab.xyz">Monster Lab.</a></p>
    </footer>
@endsection

