@extends('layouts.admin')
@section('content')
<section section class="content">
  <div class="container-fluid">
    <div class="row">
      <div id="form-data" hidden data-rules="{{ json_encode($rules) }}"
      data-messages="{{ json_encode($messages) }}"></div>
      <form class="row" action="{{route('admin.products_store')}}" method="POST" id="form__js" enctype="multipart/form-data">
        @csrf
        <div class="col-xl-12 col-lg-12 col-md-12">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Thông tin cơ bản</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="row">
              <div class="col-8">
                <div class="card-body row">
                  <x-admin-input-prepend label="Tên Sản Phẩm" width="auto">
                    <input 
                      id="name"
                      type="text" 
                      name="name"
                      class="form-control">
                  </x-admin-input-prepend>
                  <x-admin-input-prepend label="Giá Nhập" col="col-6" width="auto">
                    <input 
                      id="price_import"
                      type="number"
                      min="1" 
                      name="price_import"
                      class="form-control">
                  </x-admin-input-prepend>
                  <x-admin-input-prepend label="Giá Bán" col="col-6" width="auto">
                    <input 
                      id="price_sell"
                      type="number" 
                      name="price_sell"
                      class="form-control">
                  </x-admin-input-prepend>
                  <x-admin-input-prepend label="Thương Hiệu" width="auto" col="col-6">
                    <select class="form-control" name="brand_id" id="brand">
                      @foreach ($brands as $brand)
                          <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                      @endforeach
                    </select>
                  </x-admin-input-prepend>
                  <x-admin-input-prepend label="Thời trang" width="auto" col="col-6">
                    <select class="form-control" name="parent_id" id="parent_id">
                      @foreach ($categoriesParent as $categoryParent)
                          <option value="{{ $categoryParent->id }}">{{ $categoryParent->name }}</option>
                      @endforeach
                    </select>
                  </x-admin-input-prepend>
                  <x-admin-input-prepend label="Danh Mục" width="auto">
                    <select class="form-control" name="category_id" id="category_id" route="{{ route('admin.category_by_parent') }}">
                      
                    </select>
                  </x-admin-input-prepend>
                  <div class="card card-outline card-info col-12">
                    <div class="card-header">
                      <h3 class="card-title">
                        Mô Tả Sản Phẩm
                      </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <textarea id="summernote" name="description">
                      </textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-4">
                <div class="card-body">
                  <div class="container">
                    <div class="preview">
                      <img id="img-preview" src="" />
                      <label for="file-input">Chọn Hình Ảnh</label>
                      <input hidden accept="image/*" type="file" id="file-input" name="img"/>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 text-center" style="padding-bottom: 10px;">
                <button class="btn btn-success">THÊM MỚI</button>
                <a href="{{ route('admin.product_index') }}" class="btn btn-danger">HỦY</a>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- /.container-fluid -->
</section>
<script>
</script>
@vite(
[
  'resources/admin/js/user-create.js',
  'resources/admin/js/product.js',
  'resources/admin/css/product.css',
  'resources/admin/css/form-edit.css',
  'resources/common/js/form.js',
])
@endsection