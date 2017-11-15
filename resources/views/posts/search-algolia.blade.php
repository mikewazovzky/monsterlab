@extends('posts.layout')

@section('main')
    <search query="{{ $search }}" prefix="{{ env('SCOUT_PREFIX', '') }}"></search>
@endsection
