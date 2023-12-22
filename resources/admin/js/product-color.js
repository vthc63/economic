import Swal from 'sweetalert2';

$(document).ready(function () {
  toast1 = toast1();

  // hiển thị hình ảnh khi mà chọn hình cho màu sản phẩm
  $(document).on('change', '.img-color', function () {
    const file = this.files[0];
    if (file) {
      $(this).closest('.preview').find('img')
        .attr("src", URL.createObjectURL(this.files[0]));
    }
  });
  // khi người dùng bấm lưu màu
  submitForm('submit', '.form-submit');

  // khi người dùng bấm sửa sản phẩm
  $(document).on('click', '.edit', function () {
    let url = $(this).attr('url-update');
    let urlImg = $(this).attr('url-img')
    $.ajax({
      type: 'GET',
      url: url,
    }).done((res) => {
        let option = '';
        res.colors.forEach(color => {
          if (color.id == res.productColor.color_id) {
            option+= `<option value="${color.id}" selected>${color.name}</option>`
          } else {
            option+= `<option value="${color.id}">${color.name}</option>`
          }
        });
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
                        <span class="input-group-text" style="width:100%;">Màu</span>
                      </div>
                      <select class="form-control" name="color_id" id="color_id_edit">
                        ${option}
                      </select>
                    </div>
                    <!-- /.input group -->
                  </div>
                </div>
                <div class="form-group">
                  <div class="preview">
                    <img id="img-preview" style="width: 60px" src="${urlImg + '/' + res.productColor.img}" />
                    <label for="file-input-edit" id="lable-img">Chọn Hình Ảnh</label>
                    <input class="img-color" hidden accept="image/*" type="file" id="file-input-edit" name="img"/>
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
        $('#modal-edit').modal('show');
    })
  });

  // khi xóa màu
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
              console.log("true")
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