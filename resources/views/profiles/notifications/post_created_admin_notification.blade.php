[Admin] New post
<a href="{{ route('posts.show', $notification->data['post']['slug']) }}">
    {{ $notification->data['post']['title'] }}
</a>
has been published by
<a href="{{ route('profiles.show', $notification->data['user']['slug'])}}">
    {{ $notification->data['user']['name'] }}
</a>
.
