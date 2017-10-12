[Admin] New user
<a href="{{ route('profiles.show', $notification->data['user']['slug'])}}">
    {{ $notification->data['user']['name'] }}
</a>
has been confirmed.
