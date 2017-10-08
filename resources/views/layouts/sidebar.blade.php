<div class="panel panel-default">
    <div class="panel-heading">
        Tags
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

<div class="panel panel-default">
    <div class="panel-heading">
        Latest posts
    </div>
    <div class="panel-body">
        <ul>
            @foreach($latest as $post)
                <li>
                    <a href="/posts/{{ $post->id }}">
                        {{ substr($post->title, 0, 40) . '...' }}
                    </a>
                    by
                    <a href="#">
                        {{ $post->user->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        Popular posts (top 5)
    </div>
    <div class="panel-body">
        <ul>
            @foreach($popular as $post)
                <li>
                    <a href="/posts/{{ $post->id }}">
                        {{ substr($post->title, 0, 40) . '...' }}
                    </a>
                    by
                    <a href="#">
                        {{ $post->user->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        Archives
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

<div class="panel panel-default">
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
