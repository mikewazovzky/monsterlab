@component('mail::message')
New user {{ $user->name }} [{{ $user->email }}] has been confirmed.

@component('mail::button', ['url' => route('profiles.show', $user)])
Check Out User Profile
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
