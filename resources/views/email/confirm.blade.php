@component('mail::message')
# Welcome to Monster Lab.

Pls. press the button to confirm your email address.

@component('mail::button', ['url' => 'http://monster-lab/register/confirm?token=' . $user->confirmation_token])
Confirm Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
