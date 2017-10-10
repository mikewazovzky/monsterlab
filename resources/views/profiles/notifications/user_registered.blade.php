[Admin] New user
<a href="{{ route('profiles.show', $notification->data['user']['id'])}}">
    {{ $notification->data['user']['name'] }}
</a>
has been registered.
