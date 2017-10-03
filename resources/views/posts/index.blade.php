@extends('layouts.blog')

@section('main')
    @foreach($posts as $post)
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2><a href="/posts/{{ $post->id }}">{{ $post->title }}</a></h2>
                <span><a href="#">{{ $post->user->name }}</a></span>
                posted
                <span>{{ $post->created_at->diffForHumans() }}</span>
            </div>
            <div class="panel-body">
                <p>{{ substr($post->body, 0, 255) . ' ...' }}</p>
            </div>
        </div>
    @endforeach
    {{ $posts->links() }}
@stop

@section('sidebar')
<div class="panel panel-default">
    <div class="panel-heading">
        <h2>METADATA</h2>
    </div>
    <div class="panel-body">
        CONTENT
    </div>
</div>
@stop
