$('#summernote').summernote()
$(document).ready(function(){
    const input = document.getElementById('file-input');
    const image = document.getElementById('img-preview');
  
    input.addEventListener('change', (e) => {
        if (e.target.files.length) {
            const src = URL.createObjectURL(e.target.files[0]);
            image.src = src;
            console.log(src);
        } else {
            const src = "";
            image.src = src;
        }
    });

    getCategoties();
    $(document).on('change', '#parent_id', function(){
        getCategoties();
    });
});

function getCategoties()
{
    $('#category_id').html("");
    let parentId = $('#parent_id').val();
    let url = $('#category_id').attr('route');
    $.ajax({
        type: 'GET',
        url: url + '?parent_id=' + parentId
    }).done((response) => {
        let option = '';
        response.forEach(element => {
            option += `<option value="${element.id}">${element.name}</option>`
        });
        $('#category_id').html(option);
    })
}