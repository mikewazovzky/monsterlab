[Admin] New reply has been posted to
<a href="{{ route('posts.show', $notification->data['reply']['post_id']) }}">
    {{ $notification->data['post_title'] }}
</a>
by
<a href="{{ route('profiles.show', $notification->data['user']['id'])}}">
    {{ $notification->data['user']['name'] }}
</a>.
