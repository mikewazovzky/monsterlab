@component('mail::message')
# Thank you for registering with Monster Lab.!

Pls. press the button to confirm your email address and complete the registration process.

@component('mail::button', ['url' => 'http://monster-lab/register/confirm?token=' . $user->confirmation_token])
Confirm Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
