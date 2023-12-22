@extends('layouts.admin')
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <x-table-crud 
          :headers="$tableCrud['headers']" 
          :list="$tableCrud['list']" 
          :actions="$tableCrud['actions']"
          :routes="$tableCrud['routes']" 
        />
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
    <!-- /.container-fluid -->
</section>
@endsection