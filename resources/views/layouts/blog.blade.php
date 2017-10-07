@extends('layouts.app')

@section('header')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-sm-8 main">
                @yield('main')
            </div>

            <div class="col-sm-4 sidebar">
                @yield('sidebar')
                @include('layouts.sidebar')
            </div>

        </div>
    </div>
@stop

@section('footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
    <script>
        $('#tagsList').select2({
            placeholder: "Select tag(s)",
            tags: true,
            createTag: function (params) {
                var term = $.trim(params.term);
                if (term === '') {
                    return null;
                };

                return {
                    id: term,
                    text: term,
                    new: true
                };
            }
        }).on('select2:select', function (evt) {
            if(!evt.params.data.new) {
                return;
            }

            var select2element = $(this);

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.post('/tags', { name: evt.params.data.text }, function( data ) {
                // Add HTML option to select field
                $('<option value="' + data.id + '">' + data.name + '</option>').appendTo(select2element);
                // Replace the tag name in the current selection with the new persisted ID
                var selection = select2element.val();
                var index = selection.indexOf(data.name);
                if (index !== -1) {
                    selection[index] = data.id.toString();
                }
                select2element.val(selection).trigger('change');
            }, 'json');
        });

    </script>
@endsection
