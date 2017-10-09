{{-- SEARCH PANEL --}}
<div class="panel panel-primary">

    <div class="panel-heading">
        <strong>Search</strong>
    </div>
    <div class="panel-body">
        <form method="GET" action="/posts">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search posts title and body by query ..." />
                <div class="input-group-btn">
                    <button class="btn btn-info btn-md" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- TAGS PANEL --}}
<div class="panel panel-primary">
    <div class="panel-heading">
        <strong>Tags</strong>
    </div>
    <div class="panel-body">
        <ul>
            @foreach($tags as $tag)
                <li>
                    <a href="/posts?tag={{ $tag->name }}">{{ $tag->name }}</a>
                    <span class="label label-default">{{ $tag->posts_count }}</span>
                </li>
            @endforeach
        </ul>
    </div>
</div>
{{-- LATEST POSTS PANEL --}}
<div class="panel panel-primary">
    <div class="panel-heading">
        <strong>Latest posts</strong>
    </div>
    <div class="panel-body">
        <ul>
            @foreach($latest as $post)
                <li>
                    <a href="/posts/{{ $post->id }}">
                        {{ substr($post->title, 0, 40) . '...' }}
                    </a>
                    by
                    <a href="{{ route('profiles.show', $post->user) }}">
                        {{ $post->user->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
{{-- POPULAR POSTS PANEL --}}
<div class="panel panel-primary">
    <div class="panel-heading">
        <strong>Popular posts (top 5)</strong>
    </div>
    <div class="panel-body">
        <ul>
            @foreach($popular as $post)
                <li>
                    <a href="/posts/{{ $post->id }}">
                        {{ substr($post->title, 0, 40) . '...' }}
                    </a>
                    by
                    <a href="{{ route('profiles.show', $post->user) }}">
                        {{ $post->user->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
{{-- ARCHIVES PANEL --}}
<div class="panel panel-primary">
    <div class="panel-heading">
        <strong>Archives</strong>
    </div>
    <div class="panel-body">
        <ul>
            @foreach($archives as $period)
                <li>
                    <a href="/posts?year={{ $period['year'] }}&month={{ $period['month'] }}">{{ $period['month'] . ' ' . $period['year'] }}</a>
                    <span class="label label-default">{{ $period['published'] }}</span>
                </li>
            @endforeach
        </ul>
    </div>
</div>
{{-- ABOUT PANEL --}}
<div class="panel panel-primary">
    <div class="panel-body">
        <ul class="terms">
            <li><a href="#">О нас</a></li>
            <li><a href="#">Проекты</a></li>
            <li><a href="#">Условия использования</a></li>
            <li><a href="#">Политика конфиденциальности</a></li>
            <li><a href="#">Рекламa</a></li>
            <li><a href="#">Контакты</a></li>
        </ul>
    </div>
    <div class="panel-footer center">
        <span><a href="#">Monster-Lab, 2017</a></span>
    </div>
</div>
