@include('layouts.admin-header')
@include('layouts.admin-sidebar')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">{{ $title }}</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    @if (Session::has('success'))
        <span id="toast__js" message="{{ session('success') }}" type="success"></span>
    @elseif (Session::has('error'))
        <span id="toast__js" message="{{ session('error') }}" type="error"></span>
    @endif
      <!-- /.content-header -->
    @yield('content')
</div>
<x-loading />
@vite(['resources/admin/js/toast-message.js'])
@include('layouts.admin-footer')