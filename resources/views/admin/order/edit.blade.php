@extends('layouts.admin')
@section('content')
<section section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Thông tin đơn hàng</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="col-md-12 mt-3">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Thông tin khách hàng</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Mã KH</th>
                      <th>Họ Tên</th>
                      <th>Số Điện Thoại</th>
                      <th>Email</th>
                      <th>Địa Chỉ</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>{{ $infomation_user['id'] }}</td>
                      <td>{{ $infomation_user['name'] }}</td>
                      <td>{{ $infomation_user['phone_number'] }}</td>
                      <td>{{ $infomation_user['email'] }}</td>
                      <td>{{ $infomation_user['apartment_number'] . ', ' . $infomation_user['ward'] . ', ' . $infomation_user['district'] . ', ' . $infomation_user['city'] }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <div class="col-md-12 mt-3">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Chi tiết đơn hàng</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 100px;">Mã SP</th>
                      <th>Tên SP</th>
                      <th>Hình Ảnh</th>
                      <th>Màu</th>
                      <th>Kích Thước</th>
                      <th>Số Lượng</th>
                      <th>Đơn Giá</th>
                      <th>Thành Tiền</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $totalProductMoney = 0;?>
                    @foreach ($order_details as $order_detail)
                      <?php $totalProductMoney +=  $order_detail->unit_price *  $order_detail->quantity;?>
                      <tr>
                        <td>{{ $order_detail->product_id }}</td>
                        <td>{{ $order_detail->product_name }}</td>
                        <td class="text-center">
                          <img style="width: 70px; height:auto; object-fit: cover;" src="{{ asset("asset/client/images/products/small/$order_detail->product_img") }}" alt="">
                        </td>
                        <td>{{ $order_detail->color_name }}</td>
                        <td>{{ $order_detail->size_name }}</td>
                        <td>{{ $order_detail->quantity }}</td>
                        <td>{{ format_number_to_money($order_detail->unit_price) }}</td>
                        <td>{{ format_number_to_money($order_detail->unit_price *  $order_detail->quantity) }}</td>
                      </tr>
                    @endforeach
                    <tr>
                      <td colspan="7">Tổng Tiền Sản Phẩm</td>
                      <td><b>{{ format_number_to_money($totalProductMoney) }} VND</b></td>
                    </tr>
                    <tr>
                      <td colspan="7">Phí Vận Chuyển</td>
                      <td><b>{{ format_number_to_money($infomation_user['orders_transport_fee']) }} VND</b></td>
                    </tr>
                    <tr>
                      <td colspan="7">Phương Thức Thanh Toán</td>
                      <td><b>{{ $infomation_user['payment_name'] }}</b></td>
                    </tr>
                    <tr>
                      <td colspan="7">Tổng Tiền Đơn Hàng</td>
                      <td><b>{{ format_number_to_money($order->total_money) }} VND</b></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          @if ($order->order_status != 3)
          <div class="action col-md-12 pb-3">
            <button class="btn btn-success" data-toggle="modal" data-target="#modal-lg">Xử Lý Đơn Hàng</button>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
  <x-modal-view-detail size="modal-lg" title="Xử Lý Đơn Hàng">
    <form action="{{ route('admin.orders_update', $order->id) }}" method="post">
      @csrf
      <div class="form-group">
        <select class="form-control" name="order_status" id="order_status">
          <option value="1">Xác Nhận</option>
          <option value="2">Hủy</option>
        </select>
      </div>
      <div class="form-group">
        <x-admin-input id="note" type="text" name="note" placeholder="Nhập Ghi Chú"/>
      </div>
      <div class="form-group text-center">
        <button class="btn btn-primary">
          Xử Lý
        </button>
      </div>
    </form>
  </x-modal-view-detail>
  <!-- /.container-fluid -->
</section>
@endsection