@extends('layouts.client')
@section('content-client')
<div class="container_fullwidth content-page">
    <div class="container">
        <div class="col-md-12 container-page">
            <div class="checkout-page">
              <ol class="checkout-steps">
                <li class="steps active">
                  <h4 class="title-steps text-center">
                    @if (Session::has('status') && session('status') == 'verifify-success')
                      Xác Thực Tài Khoản Thành Công
                    @elseif(Session::has('status') && session('status') == 'forgot-password-success')
                      Thay Đổi Mật Khẩu Thành Công
                    @endif
                  </h4>
                  <div class="step-description">
                    <div class="row">
                      <div class="col-md-12 col-sm-12">
                        <div class="run-customer">
                          @if (Session::has('status') && session('status') == 'verifify-success')
                            <p class="text-center text-notification">Chúc mừng bạn tài khoản của bạn đã được xác thực thành công</p>
                          @elseif(Session::has('status') && session('status') == 'forgot-password-success')
                            <p class="text-center text-notification">Chúc mừng bạn đã thay đổi mật khẩu thành công</p>
                          @endif
                        </div>
                        <div class="text-center">
                            <a href="{{ route('user.login') }}" class="text-success btn btn-success">
                                Đăng Nhập Ngay
                            </a>
                        </div>
                      </div>
                    </div>
                  </div>
              </ol>
            </div>
          </div>
    </div>
</div>
@endsection