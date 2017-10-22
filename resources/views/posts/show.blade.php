@extends('posts.layout')

@section('main')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>{{ $post->title }}</h1>
            <div class="level">
                <div class="flex">
                    <span><a href="{{ route('profiles.show', $post->user) }}">{{ $post->user->name }}</a></span>
                    posted on
                    <strong><span>{{ $post->created_at->toDateTimeString() }}</span></strong>
                </div>
                @can('update', $post)
                    <a href="{{ route('posts.edit', $post)}}">Edit</a>
                @endcan
                &nbsp;
                @can('delete', $post)
                    <form method="POST" action="{{ route('posts.destroy', $post) }}">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-link">Delete</button>
                    </form>
                @endcan
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
        <div class="panel-body post-body">
            <p>{!! $post->body !!}</p>
        </div>
    </div>

    <replies></replies>

    @can('update', $post)
        @include('posts.adjustment-list')
    @endcan

@stop
