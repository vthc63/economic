import Swal from 'sweetalert2';

$(document).ready(function () {
  toast1 = toast1();
  getSizeByProductColor()

  //get size when color change
  $(document).on('change', '#color_id', function () {
    $('#loading__js').css('display', 'flex');
    getSizeByProductColor()
  });

  submitForm('submit', '.form-submit')

  //edit size product
  $(document).on('click', '.edit', function () {
    $('#loading__js').css('display', 'flex');
    let url = $(this).attr('url-update');
    let urlGetSize = $(this).attr('url-get-size');
    let modal = `
        <form method="post" 
          class="form-submit"
          enctype="multipart/form-data"
          url-store="${url}"
          >
            <div class="modal-body">
              <div class="form-group">
                  <div class="form-group col-12">
                      <div class="input-group">
                          <div class="input-group-prepend" style="width:auto;">
                              <span class="input-group-text" style="width:100%;">Kích thước</span>
                          </div>
                          <select class="form-control" name="size_id" id="size_id_edit">

                          </select>
                      </div>
                      <!-- /.input group -->
                  </div>
              </div>
              <div class="form-group">
                  <div class="form-group col-12">
                      <div class="input-group">
                          <div class="input-group-prepend" style="width:auto;">
                              <span class="input-group-text" style="width:100%;">Số lượng</span>
                          </div>
                          <input id="quantity_edit" type="number" min="0" name="quantity"class="form-control">
                      </div>
                      <!-- /.input group -->
                  </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </div>
      </form>
      `;
      $('#body-modal-edit').html(modal)
      getSizeByProductColorEdit(urlGetSize)
  });

  //delete size product
  $(document).on('click', '.delete', function () {

    let url = $(this).attr('url-delete');
    Swal.fire({
      title: "Bạn có chắc muốn xóa?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'CÓ',
      cancelButtonText: 'KHÔNG',
    }).then((result) => {
      if (result.isConfirmed) {
        // Display loading
        $('#loading__js').css('display', 'flex');
        $.ajax({
          type: 'POST',
          url: url,
        }).done((res) => {
          $('#loading__js').css('display', 'none');
            if (res.status == true) {
              getSizeByProductColor()
              $(this).closest('tr').remove();
              fire1(toast1, 'success', res.message)
            } else {
              console.log("false");
              fire1(toast1, 'error', res.message)
            }
        }).fail(() => {
          $('#loading__js').css('display', 'none');
          fire1(toast1, 'error', 'Có lỗi xảy ra vui lòng thử lại')
          setTimeout(()=>{
            location.reload();
          }, 2000);
        });
      }
    })
  });

});

function getSizeByProductColor()
{
    let productColorId = $('#color_id').val();
    let url = $('#size_id').attr('url-get-size')
    $.ajax({
        type: 'GET',
        url: url,
        data: {
            product_color_id: productColorId
        }
    }).done((res) => {
      renderSize(res, 'size_id')
      $('#loading__js').css('display', 'none');
    })
}

function getSizeByProductColorEdit(url)
{
    $.ajax({
        type: 'GET',
        url: url,
    }).done((res) => {
      let option = `<option>${res.size}</option>`;
      $(`#size_id_edit`).html(option)
      $('#quantity_edit').val(res.quantity);
      $('#loading__js').css('display', 'none');
      $('#modal-edit').modal('show');
    })
}

function renderSize(data, element)
{
    let option = '';
    data.forEach(element => {
        option += `<option value="${element.id}">${element.name}</option>`
    });
    $(`#${element}`).html(option)
}

function toast1() {
  return Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  });
}

function fire1(toast, type, message) {
  let background;
  let icon;
  if (type == 'success') {
    background = 'rgba(40,167,69,.85)';
    icon = 'success';
  } else if (type == 'error') {
    background = 'rgba(220,53,69,.85)';
    icon = 'error';
  }
  toast.fire({
    icon: icon,
    title: message,
    background: background,
    color: '#fff',
  })
}

function submitForm(event, element)
{
  $(document).on(event, element, function (event) {
    event.preventDefault();

    let url = $(this).attr('url-store');
    $.ajax({
      url: url,
      method: 'POST',
      data: new FormData(this),
      dataType: 'JSON',
      contentType: false,
      cache: false,
      processData: false,
      async: true,
    }).done((res) => {
      if (res.status == false) {
        fire1(toast1, 'error', res.message)
      } else if (res.status == true) {
        window.location.href = res.route;
      }
    }).fail(function (data) {
      if (data.status == 422) {
        fire1(toast1, 'error', data.responseJSON.message)
      }
    });
  });
}