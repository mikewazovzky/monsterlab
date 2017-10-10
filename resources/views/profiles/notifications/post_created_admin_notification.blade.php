[Admin] New post
<a href="{{ route('posts.show', $notification->data['post']['id']) }}">
    {{ $notification->data['post']['title'] }}
</a>
has been published by
<a href="{{ route('profiles.show', $notification->data['user']['id'])}}">
    {{ $notification->data['user']['name'] }}
</a>
.
