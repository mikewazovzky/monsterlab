<form method="POST" action="{{ $formRoute }}" enctype="multipart/form-data">
    {{ method_field($formMethod) }}
    {{ csrf_field() }}

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>{{ $formTitle }}</h3>
        </div>

        <div class="panel-body">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ getValue('title', $post ?? null) }}">
            </div>

            <div class="form-group">
                <label for="body">Article</label>
                <textarea type="text" id="body" name="body" class="form-control" rows="24">{{ getValue('body', $post ?? null) }}</textarea>
            </div>

{{--             <div class="form-group">
                <input type="file" name="featured" class="form-control">
            </div> --}}
            <featured-image src="{{ $post->featured }}"></featured-image>

            <tags :post="{{ $post ?? 'false' }}"></tags>

        </div><!-- panel-body -->

        <div class="panel-footer panel-custom">
            <div>
                {{ $slot }}
            </div>

            <div>
                @include('layouts.errors')
            </div>
        </div><!-- panel-footer -->
    </div><!-- panel -->
</form>

<div class="well well-sm instruction">
    <strong>Правила создание/редактирования поста</strong><br>
    При создание редактировании поста допускается использование основных html тэгов,
    ссылок, изображений, и аттрибутов, в том числе аттрибута style и
    классов bootstrap.
</div>
