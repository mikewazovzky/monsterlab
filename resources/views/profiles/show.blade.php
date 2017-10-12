@extends('posts.layout')

@section('main')

    <div class="page-header">
        <div class="level">
            <avatar-form :user="{{ $profileUser }}" :changable="true"></avatar-form>
            <h1>{{ $profileUser->name }}</h1>
        </div>

        @if(auth()->id() == $profileUser->id && $profileUser->isReader() )
            <div class="well well-sm">
                Your e-mail has not been confirmed yet.
                Pls. press the <a href="{{ route('register.send') }}">link</a> to resend email confirmation request.
            </div>
        @endif
    </div>

    {{-- USER ROLE FORM --}}
    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-horizontal" method="POST" action="{{ route('user.update.role', $profileUser) }}">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}

                <div class="form-group form-group-sm">
                    <label for="role" class="col-sm-3 control-label">Role</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="role" name="role"
                        @cannot('admin', $profileUser)
                            disabled
                        @endcannot
                        >
                            <option value="admin"  {{ $profileUser->role == 'admin'  ? 'selected' : ''}}>admin</option>
                            <option value="reader" {{ $profileUser->role == 'reader' ? 'selected' : ''}}>reader</option>
                            <option value="writer" {{ $profileUser->role == 'writer'  ? 'selected' : ''}}>writer</option>
                        </select>
                    </div>
                </div>

                @can('admin', $profileUser)
                    <div class="form-group form-group-sm">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-sm btn-info">Update</button>
                        </div>
                    </div>
                @endcan

            </form>
        </div>
    </div>


    {{-- USER NAME and EMAIL ROLE FORM --}}
    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-horizontal" method="POST" action="{{ route('user.update.data', $profileUser) }}">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}

                <div class="form-group form-group-sm">
                    <label for="name" class="col-sm-3 control-label">Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="name" name="name" value="{{ $profileUser->name }}"
                            @cannot('admin', $profileUser)
                                disabled
                            @endcannot
                        >
                    </div>
                </div>

                @can('update', $profileUser)

                    <div class="form-group form-group-sm">
                        <label for="email" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="email" name="email" value="{{ $profileUser->email }}">
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-sm btn-info">Update</button>
                        </div>
                    </div>

                @endcan

            </form>
        </div>
    </div>

    {{-- USER PASSWORD FORM --}}
    @can('update', $profileUser)
        <div class="panel panel-default">
            <div class="panel-body">
                <form class="form-horizontal" method="POST" action="{{ route('user.update.password', $profileUser) }}">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}

                    <div class="form-group form-group-sm">
                        <label for="password" class="col-sm-3 control-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="password" name="password" value="**************">
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <label for="password_confirmation" class="col-sm-3 control-label">Confirm Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="**************">
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-sm btn-info">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @include('layouts.errors')

    @endcan

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
        There are no notifications for you at the moment.
    @endif

@endsection
