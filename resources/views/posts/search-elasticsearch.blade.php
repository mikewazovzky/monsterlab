@extends('posts.layout')

@section('main')
    <br>
    <form method="GET" action={{ route('posts.elasticsearch') }} >
        <div class="input-group add-on">
            <input class="form-control" placeholder="Search" name="search" type="text" value="{{ $search ?: '' }}">
            <div class="input-group-btn">
                <button class="btn btn-info" type="submit"><span class="glyphicon glyphicon-search"></span></button>
            </div>
        </div>
        <div class="pull-right">
            <small>powered by</small>
            <a href="https://www.elastic.co/products/elasticsearch">
                <img class="elastic-image pull-right" src="/images/elasticsearch24.png">
            </a>
        </div>
    </form>
    <br>

    @if(count($posts))
        <h6 class="text-center">
            Results {{ 1 + ($page - 1) * 10 }} -
            {{ (10 * $page) > $posts->total() ?  $posts->total() : $page * 10 }}
            of {{ $posts->total() }}
        </h6>
        <ul class="list-group">
            @foreach($posts as $post)
                <li class="list-group-item">
                    <a href="{{ route('posts.show', $post) }}">{!! $post->getTitle($search) !!}</a>
                    by
                    <a href="{{ route('profiles.show', $post->user) }}">{!! highlight($search, $post->user->name) !!}</a>
                    <br>
                    {!! $post->getExcerpt($search, 399) !!}
                </li>
            @endforeach
        </ul>
        <div class="text-center">
            {{ $posts->appends(request()->capture()->except('page'))->links() }}
        </div>
    @endif

@endsection
