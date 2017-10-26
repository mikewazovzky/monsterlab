@component('mail::message')
# Website Feedback Message

<strong>From:</strong> {{ $feedbackData['name'] }} <<a href="#">{{ $feedbackData['email']}}</a>><br>
<strong>Subj:</strong> {{ $feedbackData['subj']}}<br>
<strong>The body of your message:</strong><br>
{{ $feedbackData['body'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
