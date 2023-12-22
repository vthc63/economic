@extends('layouts.client')
@section('content-client')
<div class="container_fullwidth" style="min-height: calc(100vh - 389px);">
    <div class="container">
        <div class="hot-products">
            <h3 class="title">
                @if (count($products) > 0)
                    Kết quả tìm kiếm cho từ khoá '<span style="color:#f7544a;">{{ $contentSearch }}</span>'
                @else
                    Chúng tôi không tìm thấy sản phẩm '<span style="color:#f7544a;">{{ $contentSearch }}</span>' nào       
                @endif
            </h3>
            <form class="row" method="GET">
                <input type="text" value="{{ $contentSearch }}" hidden name="keyword">
                <div class="col-sm-3">
                    <div class="form-group">
                        <select class="form-control form-select" name="category">
                            <option disabled selected>Chọn danh mục</option>
                            <option value="" >Tất cả</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" >{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <select class="form-control form-select" name="brand">
                            <option disabled selected>Chọn thương hiệu</option>
                            @foreach ($brands as $item)
                                <option value="{{ $item->id }}" {{ ($item->id == $brand) ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group" style="display: flex; align-items: center;">
                        <input type="text" class="form-control price-filter" value="{{ $minPrice }}" placeholder="Giá từ" name="min_price">
                        <span style="border-top: 1px; width: 50px;"></span>
                        <input type="text" class="form-control price-filter" value="{{ $maxPrice }}" placeholder="Giá đến" name="max_price">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <button class="price-filter">Lọc tìm kiếm</button>
                    </div>
                </div>
            </form>
            <ul>
                <li>
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-md-3 col-sm-6">
                            <div class="products">
                                <div class="thumbnail">
                                    <a href="{{ route('user.products_detail', $product->id) }}"><img src="{{ asset("asset/client/images/products/small/$product->img") }}" alt="Product Name"></a>
                                </div>
                                <div class="productname" style="height: 42px;">{{ $product->name }}</div>
                                <h4 class="price">{{ format_number_to_money($product->price_sell) }} VNĐ</h4>
                                <div class="productname" style="padding-bottom: 10px; padding-top: unset;">
                                    <x-avg-stars :number="$product->avg_rating" />
                                    <span style="font-size: 14px;">Đã bán: {{ $product->sum }}</span>
                                </div>
                                <div class="button_group">
                                    <a href="{{ route('user.products_detail', $product->id) }}" class="button add-cart" type="button">Xem Chi Tiết</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                </li>
            </ul>
        </div>
        <div class="text-center">
            <ul class="pagination">
                {{ $products->links('vendor.pagination.default') }}
            </ul>
        </div>
    </div>
</div>
@vite(['resources/client/css/search.css'])
@endsection