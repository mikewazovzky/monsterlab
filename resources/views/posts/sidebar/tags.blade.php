{{-- TAGS PANEL --}}
<div class="panel panel-primary">

    <div class="panel-heading">
        <strong>Tags</strong>
    </div>

    <div class="panel-body">
        <ul class="sidebar-ul">
            @foreach($tags as $tag)
                <li>
                    <a href="/posts?tag={{ $tag->name }}">{{ $tag->name }}</a>
                    <span class="label label-info">{{ $tag->posts_count }}</span>
                </li>
            @endforeach
        </ul>
    </div>

</div>
