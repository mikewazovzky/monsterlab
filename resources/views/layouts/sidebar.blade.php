<div class="panel panel-default">
    <div class="panel-heading">
        Tags
    </div>
    <div class="panel-body">
        <ul>
            @foreach($tags as $tagName)
                <li><a href="/posts/tags/{{ $tagName }}">{{ $tagName }}</a></li>
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
