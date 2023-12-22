@extends('layouts.admin-auth')
@section('content-auth')
<div class="login-box" style="width:80%; max-width:450px;">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <p class="h3"><b>Xác Thực Tài Khoản</b></p>
    </div>
    <div class="card-body">
      <p class="login-box-msg">
          Để tiếp tục đăng nhập bạn vui lòng xác minh địa chỉ email của mình bằng cách bấm nút bên dưới
          chúng tôi sẽ gửi liên kết xác nhận đến cho bạn. Xin cảm ơn.
        @if (session('status') == 'verification-link-sent')
            <div class="login-box-msg text-success">
              Một liên kết xác thực mới đã được gửi đến địa chỉ email của bạn.
            </div>
        @endif
      </p>
      <form action="{{ route('admin.verification.send') }}" method="post" id="login-form__js">
        @csrf
        <div class="row">
          <!-- /.col -->
          <div class="col-6">
            <button id="btn-submit" type="submit" class="btn btn-primary btn-block">Gửi Email</button>
          </div>
          <div class="col-6 text-right d-flex align-items-center">
            <a href="{{route('admin.logout')}}" style="flex-grow: 1;">Đăng xuất</a>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
@endsection
