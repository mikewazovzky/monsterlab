@extends('layouts.blog')

@section('main')
    @component('posts.form', [
        'formTitle' => 'Edit Post',
        'formMethod' => 'PATCH',
        'formRoute' => route('posts.update', $post),
        'post' => $post,
    ])
    <button type="reset" class="btn btn-default">Reset</button>
    <button type="submit" class="btn btn-primary">Save</button>
    @endcomponent
@endsection
