@extends('posts.layout')

@section('main')
    <search query="{{ $query }}" prefix="{{ env('SCOUT_PREFIX', '') }}"></search>
@endsection
