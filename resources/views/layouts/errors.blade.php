@if ($errors->any())
    <div class="errors">
        @foreach($errors->all() as $error)
            <div class = "alert alert-danger" style="margin-top: 2px; margin-bottom: 2px; padding: 5px;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close" >&times;</a>
                {{ $error }}
            </div>
        @endforeach
    </div>
@endif
