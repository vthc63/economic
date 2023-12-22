@props(['list', 'size', 'title', 'route'])
<div class="modal fade" id="{{ $size }}">
  {{-- <input hidden type="text" id="route" value="{{ $route }}"> --}}
    <div class="modal-dialog {{ $size }}">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">{{ $title }}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  {{ $slot }}
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </section>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>