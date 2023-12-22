@extends('layouts.admin')
@section('content')
<section section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Thay đổi mật khẩu cá nhân</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <x-form-crud 
            route="{{ route('admin.profile_update-password') }}"
            :fields="$fields"
            :rules="$rules"
            :messages="$messages"
            textSubmit="Cập Nhật"
            cancelBtn="false"
          />
        </div>
      </div>
    </div>
  </div>
  <!-- /.container-fluid -->
</section>
@endsection