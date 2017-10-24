{{-- TRENDING POSTS PANEL --}}
@if(count($trending))
    <div class="panel panel-primary">
        <div class="panel-heading">
            <strong>Trending posts (top 5)</strong>
        </div>

        <div class="panel-body">
            <ul class="sidebar-ul">
                @foreach($trending as $post)
                    <li>
                        <a href="/posts/{{ $post->slug }}">
                            {{ mb_substr($post->title, 0, 28) . '...' }}
                        </a>
                        by
                        <a href="{{ route('profiles.show', $post->user->slug) }}">
                            {{ $post->user->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
