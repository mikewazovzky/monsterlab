[Admin] New reply has been posted to
<a href="{{ route('posts.show', $notification->data['post_slug']) }}">
    {{ $notification->data['post_title'] }}
</a>
by
<a href="{{ route('profiles.show', $notification->data['user']['slug'])}}">
    {{ $notification->data['user']['name'] }}
</a>.
