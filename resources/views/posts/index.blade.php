@extends('layouts.blog')

@section('main')
    @foreach($posts as $post)
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2><a href="/posts/{{ $post->id }}">{{ $post->title }}</a></h2>
                <div class="level">
                    <div class="flex">
                        <span><a href="#">{{ $post->user->name }}</a></span>
                        posted
                        <span>{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                    <div>
                        <ul class="tags">
                            @foreach($post->tags as $tag)
                                <li>{{ $tag->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <p>{{ substr($post->body, 0, 255) . ' ...' }}</p>
            </div>
            <div class="panel-footer">
                Views: {{ $post->views }}
            </div>
        </div>
    @endforeach
    {{ $posts->links() }}
@stop
