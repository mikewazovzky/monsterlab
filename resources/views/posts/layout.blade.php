@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-9 main">
                @yield('main')
            </div>

            <div class="col-md-3 sidebar">
                @include('posts.sidebar')
            </div>

        </div>
    </div>
@stop
