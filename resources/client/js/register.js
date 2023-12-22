$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            token: "24d5b95c-7cde-11ed-be76-3233f989b8f3"
        },
    });

    //khi người dùng thay đổi tỉnh thành
    $(document).on('change', '#city', function(){
        //xóa tất cả các html có trong quận huyện 
        $('#district').html("");
        //xóa tất cả các html có trong phường xã
        $('#ward').html("");
        //hiển thị lại thông quận huyên và phường xã
        getProvind();
    });

    $(document).on('change', '#district', function(){
        $('#ward').html("");
        // get list ward
        getWard();
    });
    //check click btn submit
    $(document).on('submit', '#form__js', function(){
        //display loading
        $('#loading__js').css('display', 'flex');
    });

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
    // kiểm tra xem người dùng nhập đầy thông tin hay chưa trước khi gửi liệu lên server
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
});

// fucntion get district
function getProvind()
{
    let provinceId = $('#city').val();
    // gửi mã thành phố hoặc tỉnh lên đường dẫn https://online-gateway.ghn.vn/shiip/public-api/master-data/district để lấy tất cả các quận huyện thuộc tỉnh đó
    $.ajax({
        type: 'GET',
        url: 'https://online-gateway.ghn.vn/shiip/public-api/master-data/district',
        data: {
            province_id: provinceId
        }
    }).done((respones) => {
        let option = '';
        //Hiển thị quận huyện thuộc tỉnh đó
        respones.data.forEach(element => {
            option = `<option value="${element.DistrictID}">${element.DistrictName}</option>`
            $('#district').append(option);
        });
        //hiển thị phường xã
        getWard();
    });
}

//function get ward
function getWard()
{
    let district_id  = $('#district').val();
    // lấy tất cả các phường xã thuộc quận huyện đó
    $.ajax({
        type: 'GET',
        url: 'https://online-gateway.ghn.vn/shiip/public-api/master-data/ward',
        data: {
            district_id : district_id 
        }
    }).done((respones) => {
        let option = '';
        //Hiển thị phường xã thuộc quận huyện đó
        respones.data.forEach(element => {
            option = `<option value="${element.WardCode}">${element.NameExtension[0]}</option>`
            $('#ward').append(option);
        });
    });
}