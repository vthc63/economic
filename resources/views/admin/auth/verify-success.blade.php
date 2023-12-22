@extends('layouts.admin-auth')
@section('content-auth')
<div class="login-box" style="width:80%; max-width:450px;">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <p class="h3"><b>Xác Thực Tài Khoản Thành Công</b></p>
    </div>
    <div class="card-body">
      <p class="login-box-msg text-success">
          Chúc mừng bạn tài khoản của bạn đã được xác thực thành công
      </p>
      <div class="row">
          <!-- /.col -->
          <div class="col-12 text-center">
            <a href="{{route('admin.home')}}">Tiếp Tục</a>
          </div>
          <!-- /.col -->
      </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
@endsection
