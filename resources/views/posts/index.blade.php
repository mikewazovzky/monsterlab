@extends('posts.layout')

@section('main')
    @foreach($posts as $post)
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h2>
                <div class="level">
                    <div class="flex">
                        <span><a href="{{ route('profiles.show', $post->user) }}">{{ $post->user->name }}</a></span>
                        posted
                        <em><span>{{ $post->created_at->diffForHumans() }}</span></em>
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
                <p>{{ mb_substr(strip_tags($post->body), 0, 399) . ' ...' }}</p>
            </div>
            <div class="panel-footer">
                @if($post->views)
                    Views: {{ $post->views }}
                @else
                    No views.
                @endif
            </div>
        </div>
    @endforeach
    {{ $posts->links() }}
@stop
