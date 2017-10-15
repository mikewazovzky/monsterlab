<form method="POST" action="{{ $formRoute }}">
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
