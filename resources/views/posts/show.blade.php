@extends('posts.layout')

@section('header')
    <meta name="twitter:card" content="summary" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="http://m-lab.xyz/posts/{{ $post->slug }}" />
    <meta property="og:title" content="{{ $post->title }}" />
    <meta property="og:description" content="{{ mb_substr(strip_tags($post->body), 0, 399) . ' ...' }}" />
    <meta property="og:image" content="http://m-lab.xyz/images/team1.jpg" />
@endsection

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

                {{-- TWITTER BUTTON --}}
                <a class="twitter-share-button mr-1" href="https://twitter.com/intent/tweet">Tweet</a>

                {{-- FACEBOOK SHARE BUTTON --}}
                <div class="fb-share-button"
                    data-href="http://m-lab.xyz/posts/{{ $post->slug }}"
                    data-layout="button"
                    data-size="small"
                    data-mobile-iframe="true">
                    <a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">
                        Поделиться
                    </a>
                </div>
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
        @include('posts.adjustments-list', ['adjustments' => $post->lastAdjustments])
        <div>
            List of all <a href="{{ route('adjustments.index', $post) }}">adjustments</a>
        </div>
    @endcan

@stop

@section('footer')
<script>
    window.twttr = (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0],
        t = window.twttr || {};
        if (d.getElementById(id)) return t;
        js = d.createElement(s);
        js.id = id;
        js.src = "https://platform.twitter.com/widgets.js";
        fjs.parentNode.insertBefore(js, fjs);
        t._e = [];
        t.ready = function(f) {
            t._e.push(f);
        };
        return t;
    }(document, "script", "twitter-wjs"));
</script>

<div id="fb-root"></div>
<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_EN/sdk.js#xfbml=1&version=v2.10&appId=135033603917736';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

@endsection
