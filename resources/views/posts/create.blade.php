@extends('posts.layout')

@section('main')
    @component('posts.form', [
        'formTitle' => 'Create new Post',
        'formMethod' => 'POST',
        'formRoute' => route('posts.store'),
    ])
    <button type="submit" class="btn btn-primary">Create</button>
    @endcomponent
@endsection
