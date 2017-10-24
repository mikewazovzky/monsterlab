{{-- LATEST POSTS PANEL --}}
<div class="panel panel-primary">

    <div class="panel-heading">
        <strong>Latest posts</strong>
    </div>

    <div class="panel-body">
        <ul class="sidebar-ul">
            @foreach($latest as $post)
                <li>
                    <a href="{{ route('posts.show', $post) }}">
                        {{ mb_substr($post->title, 0, 30) . '...' }}
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
