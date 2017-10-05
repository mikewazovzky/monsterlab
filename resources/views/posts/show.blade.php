@extends('layouts.blog')

@section('main')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>{{ $post->title }}</h1>
            <div class="level">
                <div class="flex">
                    <span><a href="#">{{ $post->user->name }}</a></span>
                    posted
                    <span>{{ $post->created_at->diffForHumans() }}</span>
                </div>
                <a href="{{ route('posts.edit', $post)}}">Edit</a>
                &nbsp;
                <form method="POST" action="{{ route('posts.destroy', $post) }}">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-link">Delete</button>
                </form>
            </div>

            @unless($post->tags->isEmpty())
            Tags:
            <ul class="tags">
                @foreach($post->tags as $tag)
                    <li><a href="/posts/tags/{{ $tag->name}}">{{ $tag->name }}</a></li>
                @endforeach
            </ul>
            @endunless

        </div>
        <div class="panel-body">
            <p>{{ $post->body }}</p>
        </div>
    </div>
@stop
