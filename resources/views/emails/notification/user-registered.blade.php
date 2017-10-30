@component('mail::message')
New user {{ $user->name }} [{{ $user->email }}] has been registered.

@component('mail::button', ['url' => route('profiles.show', $user)])
Checkout User Profile
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
