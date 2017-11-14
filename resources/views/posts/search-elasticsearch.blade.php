@extends('posts.layout')

@section('main')
    <br>
    <form method="GET" action={{ route('posts.elasticsearch') }} >
        <div class="input-group add-on">
            <input class="form-control" placeholder="Search" name="query" type="text" value="{{ $query ?: '' }}">
            <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
            </div>
        </div>
    </form>
    <br>

    @if(count($results))
        <h4 class="text-center">
            Results {{ 1 + ($page - 1) * 10 }} -
            {{ (10 * $page) > $results->total() ?  $results->total() : $page * 10 }}
            of {{ $results->total() }}
        </h4>
        <ul class="list-group">
            @foreach($results as $result)
                <li class="list-group-item">
                    <a href="{{ route('posts.show', $result) }}">{!! highlight($query, $result->title) !!}</a>
                    <br>
                    {!! highlight($query, mb_substr($result->body, 0, 235)) . '...' !!}
                </li>
            @endforeach
        </ul>
        <div class="text-center">
            {{ $results->links() }}
        </div>
    @endif

@endsection
