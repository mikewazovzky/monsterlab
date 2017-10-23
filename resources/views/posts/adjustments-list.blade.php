<div class="panel panel-default">
    <div class="panel-heading">
        История изменений поста
    </div>

    <ul class="list-group">
        @forelse($adjustments as $adjustment)
            @include('posts.adjustment')
        @empty
            Threre no changes logged.
        @endforelse
    </ul>
</div>
