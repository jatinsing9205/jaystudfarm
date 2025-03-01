$(function () {
    $('.select2').select2({
        theme: 'bootstrap4'
    });
    $('.select2').each(function () {
        $(this).next('.select2-container').find('.select2-selection').addClass('form-select');
    });
});

$('#short_description').summernote()
$('#description').summernote()

