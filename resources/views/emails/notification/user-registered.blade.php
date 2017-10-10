@component('mail::message')
New user {{ $user->name }} [{{ $user->email }}] has been registered.

@component('mail::button', ['url' => 'http://monster-lab/profiles/' . $user->id])
Checkout User Profile
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
