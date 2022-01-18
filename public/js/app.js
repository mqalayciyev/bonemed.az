$(function () {
    setTimeout(function () {
        $('.alert').slideUp(500);
    }, 3000);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});