@component('mail::message')
New user {{ $user->name }} [{{ $user->email }}] has been registered.

@component('mail::button', ['url' => ''])
Approve Registration
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
