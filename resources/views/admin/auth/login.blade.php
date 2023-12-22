@extends('layouts.admin-auth')
@section('content-auth')
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="../../index2.html" class="h1"><b>Admin</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg"><b>Đăng Nhập Hệ Thống</b></p>
      @if ($errors->get('disable_reason'))
        <span class="error invalid-feedback" style="display: block">
          {{ implode(", ",$errors->get('disable_reason')) }}
        </span>
      @endif
      <form action="{{ route('admin.login') }}" method="post" id="login-form__js">
        @csrf
        <div class="form-group mb-3">
          <x-admin-input id="email" type="text" value="{{ old('email') }}" name="email" placeholder="Email" />
          @if ($errors->get('email'))
            <span id="email-error" class="error invalid-feedback" style="display: block">
              {{ implode(", ",$errors->get('email')) }}
            </span>
          @endif
        </div >
        <div class="form-group mb-3">
          <x-admin-input id="password" type="password" value="{{ old('password') }}" name="password" placeholder="Mật khẩu" />
          @if ($errors->get('password'))
            <span id="password-error" class="error invalid-feedback" style="display: block">
              {{ implode(", ",$errors->get('password')) }}
            </span>
          @endif
        </div >
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button id="btn-submit" type="submit" class="btn btn-primary btn-block">Đăng Nhập</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
@vite(['resources/common/js/login.js'])
@endsection
