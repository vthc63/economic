@extends('layouts.client')
@section('content-client')
<style>
  .a-hover:hover{
    color:black !important;
  }
</style>
<div class="container_fullwidth">
    <div class="container shopping-cart">
      <div class="row">
        <div class="col-md-12">
          <h3 class="title">
            Chi Tiết Đơn Hàng {{ $order->id }}
          </h3>
          <div style="padding-bottom: 30px;">
            <a href="{{ route('order_history.index') }}" class="btn-a">Quay Lại</a>
          </div>
          <div class="clearfix">
          </div>
          <table class="table table-bordered table-cart">
            <thead>
              <tr>
                <th scope="col" class="text-center" style="width: 100px;">Mã SP</th>
                <th scope="col" class="text-center">Tên SP</th>
                <th scope="col" class="text-center">Hình Ảnh</th>
                <th scope="col" class="text-center">Màu</th>
                <th scope="col" class="text-center">Kích Thước</th>
                <th scope="col" class="text-center">Số Lượng</th>
                <th scope="col" class="text-center">Đơn Giá</th>
                <th scope="col" class="text-center">Thành Tiền</th>
              </tr>
            </thead>
            <tbody>
              <?php $totalProductMoney = 0;?>
              @foreach ($order_details as $order_detail)
                <?php $totalProductMoney +=  $order_detail->unit_price *  $order_detail->quantity;?>
                <tr>
                    <td>{{ $order_detail->product_id }}</td>
                    <td>
                      <a href="{{ route('user.products_detail', $order_detail->product_id) }}">{{ $order_detail->product_name }}</a>
                    </td>
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
                <td style="font-weight: 600;">{{ format_number_to_money($totalProductMoney) }} VND</td>
              </tr>
              <tr>
                <td colspan="7">Phí Vận Chuyển</td>
                <td style="font-weight: 600;">{{ format_number_to_money($infomationUser->orders_transport_fee) }} VND</td>
              </tr>
              <tr>
                <td colspan="7">Phương Thức Thanh Toán</td>
                <td>
                    <span class="badge badge-info">{{ $infomationUser->payment_name }}</span>
                </td>
              </tr>
              <tr>
                <td colspan="7">Tổng Tiền Đơn Hàng</td>
                <td style="font-weight: 600;"   >
                    {{ format_number_to_money($order->total_money) }} VND
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="clearfix">
      </div>
    </div>
</div>
@vite(['resources/client/css/cart.css'])
@endsection