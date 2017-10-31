@extends('posts.layout')

@section('main')

    <div class="page-header">
        <h1>Oauth</h1>
    </div>

    <passport-clients></passport-clients>
    <passport-authorized-clients></passport-authorized-clients>
    <passport-personal-access-tokens></passport-personal-access-tokens>

@endsection
