@extends('posts.layout')

@section('main')

    <div class="page-header">
        <h1>{{ $profileUser->name }}</h1>
        @if($profileUser->isReader())
            <div class="well well-sm">
                Your e-mail has not been confirmed yet.
                Pls. press the <a href="{{ route('register.send') }}">link</a> to resend email confirmation request.
            </div>
        @endif
    </div>

    @if($notifications && $notifications->count())
        <table class="table table-condensed">
            @foreach($notifications as $notification)
                <tr>
                    <td>
                        {{ $notification->created_at->toDateTimeString() }}
                    </td>
                    <td>
                        @if(view()->exists($viewName ='profiles.notifications.' . snake_case(class_basename($notification->type))))
                            @include($viewName)
                        @else
                            {{ $notification->type }}
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('notifications.markAsRead', [$profileUser, $notification]) }}">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button class="btn btn-xs btn-info">Mark As Read</button>
                        </form>
                    </td>
                <tr>
            @endforeach
        </table>

        <form method="POST" action="{{ route('notifications.markAllAsRead', $profileUser) }}">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <button class="btn btn-info">Mark ALL Read</button>
        </form>
    @else
        There are no notifications at the moment.
    @endif

@endsection
