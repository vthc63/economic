$(document).ready(function(){
    //validation login
    $('#login-form__js').validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
            },
        },
        messages: {
            email: {
                required: "Vui lòng nhập Email",
                email: "Địa chỉ email không hợp lệ",
            },
            password: {
                required: "Vui lòng nhập mật khẩu",
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
    })

    // Display loading when submit login
    $(document).on('submit', '#login-form__js', function(){
        $('#loading__js').css('display', 'flex');
    });
});