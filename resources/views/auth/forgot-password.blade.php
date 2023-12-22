@extends('layouts.client')
@section('content-client')
<div class="container_fullwidth content-page">
    <div class="container">
        <div class="col-md-12 container-page">
            <div class="checkout-page">
              <ol class="checkout-steps">
                <li class="steps active">
                  <h4 class="title-steps text-center">
                    Quên Mật Khẩu
                  </h4>
                  <div class="step-description">
                    <div class="row">
                      <div class="col-md-12 col-sm-12">
                        <div class="run-customer">
                          <form action="{{ route('user.forgot_password_create') }}" method="POST" id="login-form__js">
                            @csrf
                            @if (Session::has('notify'))
                              <p style="font-size: 15px;" class="text-success">{{ session('notify') }}</p>
                            @endif
                            <div class="form-group">
                              <label for="exampleInputEmail1">Email đăng kí</label>
                              <input type="text" class="form-control" value="{{ old('email') }}" id="email" name="email" placeholder="Nhập email đăng kí tài khoản">
                              @if ($errors->get('email'))
                                <span id="email-error" class="error invalid-feedback" style="display: block">
                                  {{ implode(", ",$errors->get('email')) }}
                                </span>
                              @endif
                            </div>
                            <div class="text-center">
                                <button>
                                  Quên Mật Khẩu
                                </button>
                            </div>
                            <div>
                                <a href="{{ route('user.login') }}">
                                  Quay lại trang đăng nhập
                                </a>
                            </div>
                          </form>
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