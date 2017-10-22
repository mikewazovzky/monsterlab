<div class="panel panel-default">
    <div class="panel-heading">
        История изменений поста
    </div>

        <ul class="list-group">
            @foreach($post->adjustments as $adjustment)
                @include('posts.adjustment')
            @endforeach
        </ul>

</div>
