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

    <user-data-role :user="{{ $profileUser }}"></user-data-role>
    <user-data :user="{{ $profileUser }}"></user-data>
    <user-data-password :user="{{ $profileUser }}"></user-data-password>

    <notifications :user="{{ $profileUser }}"></notifications>

@endsection
