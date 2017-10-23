@extends('posts.layout')

@section('main')
    @include('posts.adjustments-list')
    {{ $adjustments->links() }}
@endsection
