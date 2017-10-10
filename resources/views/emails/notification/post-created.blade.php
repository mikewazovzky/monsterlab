@component('mail::message')
# New post created: {{ $post->title }}

### by {{ $post->user->name }}

<blockquote>
    {{ substr($post->body, 0, 255) . '...' }}
</blockquote>

@component('mail::button', ['url' => 'http://monster-lab/posts/' . $post->id])
View post
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
