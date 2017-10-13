webpackJsonp([3],{

/***/ "./resources/assets/js/tags.js":
/***/ (function(module, exports) {

$('#tagsList').select2({
    placeholder: "Select tag(s)",
    tags: true,
    createTag: function createTag(params) {
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
    if (!evt.params.data.new) {
        return;
    }

    var select2element = $(this);

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $.post('/tags', { name: evt.params.data.text }, function (data) {
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

/***/ }),

/***/ 1:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/tags.js");


/***/ })

},[1]);