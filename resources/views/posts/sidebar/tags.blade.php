{{-- TAGS PANEL --}}
<div class="panel panel-primary">

    <div class="panel-heading">
        <strong>Tags</strong>
    </div>

    <div class="panel-body">
        <ul class="sidebar-ul">
            @foreach($tags as $name => $count)
                <li>
                    <a href="/posts?tag={{ $name }}">{{ $name }}</a>
                    <span class="label label-info">{{ $count }}</span>
                </li>
            @endforeach
        </ul>
    </div>

</div>
