@extends('layouts.admin')
@section('content')
<style>
  .note-editable{
    min-height: 200px;
  }
</style>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <form class="row" action="{{route('admin.setting_index')}}" method="POST" id="form__js" enctype="multipart/form-data">
            @csrf
            <div class="col-xl-12 col-lg-12 col-md-12">
              <div class="card card-default">
                <div class="card-header">
                  <h3 class="card-title">Thông tin cấu hình</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="row">
                  <div class="col-12">
                    <div class="card-body row">
                      <x-admin-input-prepend label="Tên Website" width="120px">
                        <input 
                          id="name"
                          type="text" 
                          name="name"
                          value="{{ $setting->name }}"
                          class="form-control">
                      </x-admin-input-prepend>
                      <x-admin-input-prepend label="Logo website" width="120px">
                        <input type="file" name="logo" class="form-control" id="inputFile__js">
                      </x-admin-input-prepend>
                      <x-admin-input-prepend label="Email" width="120px">
                        <input 
                          id="email"
                          type="email" 
                          name="email"
                          value="{{ $setting->email }}"
                          class="form-control">
                      </x-admin-input-prepend>
                      <x-admin-input-prepend label="Địa chỉ" width="120px">
                        <input 
                          id="name"
                          type="text" 
                          name="address"
                          value="{{ $setting->address }}"
                          class="form-control">
                      </x-admin-input-prepend>
                      <x-admin-input-prepend label="Số điện thoại" width="120px">
                        <input 
                          id="phone_number"
                          type="text" 
                          name="phone_number"
                          value="{{ $setting->phone_number }}"
                          class="form-control">
                      </x-admin-input-prepend>
                      <x-admin-input-prepend label="Bảo trì website" width="120px">
                        <select class="form-control" name="maintenance" id="maintenance">
                          <option value="1"
                          @if ($setting->maintenance == 1)
                              @selected(true)
                          @endif>Bật</option>
                          <option value="2" @if ($setting->maintenance == 2)
                            @selected(true)
                        @endif>Tắt</option>
                        </select>
                      </x-admin-input-prepend>
                      <div class="form-group col-12">
                        <div class="input-group">
                          <div class="card card-outline card-info col-12">
                            <div class="card-header">
                              <h3 class="card-title">
                                Nội dung bảo trì
                              </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                              <textarea id="notification" name="notification" >
                                {!! $setting->notification !!}
                              </textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-12">
                        <div class="input-group">
                          <div class="card card-outline card-info col-12">
                            <div class="card-header">
                              <h3 class="card-title">
                                Giới thiệu website
                              </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                              <textarea id="introduction" name="introduction">
                                {!! $setting->introduction !!}
                              </textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 text-center" style="padding-bottom: 10px;">
                    <button class="btn btn-success">CẬP NHẬT THÔNG TIN</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
    <!-- /.container-fluid -->
</section>
@vite(
[
  'resources/admin/js/setting.js',
])
@endsection