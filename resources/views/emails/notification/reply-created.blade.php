@component('mail::message')
# New reply created
Post: <a href="#">{{ $reply->post->title }}</a><br>
commented by <a href="#">{{ $reply->user->name }}</a>
<blockquote>
    {{ $reply->body }}
</blockquote>

@component('mail::button', ['url' => ''])
Link
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
