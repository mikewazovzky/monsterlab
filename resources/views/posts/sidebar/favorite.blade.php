{{-- FAVORITE PANEL --}}
@auth
    <div class="panel panel-primary sidebar-favorite">
            <a href="{{ route('posts.index', ['favorite' => true]) }}">
        <div class="panel-heading">
                <span class="glyphicon glyphicon-star"></span>
                <strong>Favorite</strong>
        </div>
            </a>
    </div>
@endauth
