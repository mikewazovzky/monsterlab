@component('mail::message')
# New comment created
Post: <a href="#">{{ $comment->post->title }}</a><br>
commented by <a href="#">{{ $comment->user->name }}</a>
<blockquote>
    {{ $comment->body }}
</blockquote>

@component('mail::button', ['url' => route('posts.show', $comment->post)])
Link
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
