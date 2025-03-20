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

$(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function (event) {
        event.preventDefault();
        $(this).ekkoLightbox({
            alwaysShowClose: true
        });
    });
})

function clearError() {
    $(".error").text('');
}

$(document).ready(function () {
    $('#lightSlider').lightSlider({
        gallery: true,
        item: 1,
        loop: true,
        thumbItem: 9,
        slideMargin: 0,
        enableDrag: true,
        currentPagerPosition: 'left',
        vertical: true,
        verticalHeight: 400,
        vThumbWidth: 60,
    });
    $(".lSPrev").html('<i class="fa fa-angle-down"></i>');
    $(".lSNext").html('<i class="fa fa-angle-up"></i>');
})