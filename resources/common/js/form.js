$(document).ready(function(){
    const rules = $("#form-data").data("rules");
    const messages = $("#form-data").data("messages");

    $.validator.addMethod("checklower", function (value) {
        return value ? /[a-z]/.test(value) : true;
    });
    $.validator.addMethod("checkupper", function (value) {
        return value ? /[A-Z]/.test(value) : true;
    });
    $.validator.addMethod("checkdigit", function (value) {
        return value ? /[0-9]/.test(value) : true;
    });
    $.validator.addMethod("checkspecialcharacter", function (value) {
        return value ? /[%#@_\-]/.test(value) : true;
    });

    $("#form__js").validate({
        rules: rules ?? "",
        messages: messages ?? "",
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        submitHandler: (form) => {
            form.submit();
            $('#loading__js').css('display', 'flex');
        },
    });

    // Add name file to input file
    $(document).on('change', '.inputFile__js', function(){
        let nameFile = String($('.inputFile__js').val());
        if (nameFile == '' || nameFile == null) {
            $('.custom-file-label').text('Chọn hình ảnh');
        } else {
            $('.custom-file-label').text(nameFile.split('\\')[2]);
        }
    });
});