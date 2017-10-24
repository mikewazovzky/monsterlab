{{-- ARCHIVES PANEL --}}
<div class="panel panel-primary">

    <div class="panel-heading">
        <strong>Archives</strong>
    </div>

    <div class="panel-body">
        <ul class="sidebar-ul">
            @foreach($archives as $period)
                <li>
                    <a href="/posts?year={{ $period['year'] }}&month={{ $period['month'] }}">{{ $period['month'] . ' ' . $period['year'] }}</a>
                    <span class="label label-info">{{ $period['published'] }}</span>
                </li>
            @endforeach
        </ul>
    </div>

</div>
