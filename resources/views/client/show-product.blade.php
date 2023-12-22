@extends('layouts.client')
@section('content-client')
<style>
   
    .separate {
        float: left;
        margin: 0 5px 0 5px;
        font-size: 24px;
        font-weight: 700;
        color: #bfbfbf;
    }
    .checkboxx {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border: 1px solid #ccc;
        border-radius: 0;
        width: 14px;
        height: 14px;
        outline: none;
        cursor: pointer;
    }

    .checkboxx:checked::before {
    content: "\2713";
    display: inline-block;
    text-align: center;
    font-size: 12px;
    width: 14px;
    height: 14px;
    line-height: 14px;
    color: #fff;
    background-color: #007bff;
    border: 2px solid #007bff;
    }

    .name-filter{
        display: inline !important;
        margin-top: 1px;
    }

    .checkboxx:focus{
        outline: none !important;
        outline: none !important;
        outline-offset: unset !important;
    }
</style>
<div class="container_fullwidth">
    <div class="container">
        <div class="row">
            <form method="get">
                <div class="col-md-3">
                    <div class="category leftbar">
                    <h3 class="title">
                        Danh Mục Sản Phẩm
                    </h3>
                    <ul>
                        @foreach ($categories as $category)
                            <li>
                                <input type="radio" class="checkboxx" value="{{ $category->slug }}" {{ ($categorySlug == $category->slug) ? 'checked' : '' }} name="category_slug">
                                <a class="name-filter">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    </div>
                    <div class="clearfix">
                    </div>
                    <div class="branch leftbar">
                        <h3 class="title">
                            Thương hiệu
                        </h3>
                        <ul>
                            <li>
                                <input type="radio" class="checkboxx" value="" name="brand_id" {{ ($request->brand_id == '') ? 'checked' : '' }}>
                                <a class="name-filter">
                                    Tất cả
                                </a>
                            </li>
                            @foreach ($brands as $brand)
                                <li>
                                    <input type="radio" class="checkboxx" value="{{ $brand->id }}" {{ ($request->brand_id == $brand->id) ? 'checked' : '' }} name="brand_id">
                                    <a class="name-filter">
                                        {{ $brand->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="clearfix">
                    </div>
                    <div class="price-filter leftbar" style="width:100%;">
                        <h3 class="title">
                            Khoảng Giá
                        </h3>
                        <div style="display: flex; width: 100%;">
                            <input id="min-price" type="text" value="{{ $request->min_price ?? '' }}" class="form-control price-filter" placeholder="Giá từ" name="min_price">
                            <span class="separate">-</span>
                            <input id="max-price" type="text" value="{{ $request->max_price ?? '' }}" class="form-control price-filter" placeholder="Giá đến" name="max_price">
                        </div>
                    </div>
                    <div style="display: flex; width: 100%; margin-top: 10px; justify-content: center;">
                        <button id="filter-price" url="{{ $request->fullUrl() }}">Lọc Sản Phẩm</button>
                    </div>
                    <div class="clearfix">
                    </div>
                </div>
            </form>
            <div class="col-md-9">
                <div class="products-grid">
                    <div class="row">
                        @if (count($products) > 0)
                            @foreach ($products as $product)
                                <div class="col-md-4 col-sm-6">
                                    <div class="products">
                                        <div class="thumbnail">
                                            <a href="{{ route('user.products_detail', $product->id) }}">
                                                <img src="{{ asset("asset/client/images/products/small/$product->img") }}" alt="Product Name">
                                            </a>
                                        </div>
                                        <div class="productname" style="height: 42px;">
                                            {{ $product->name }}
                                        </div>
                                        <h4 class="price">
                                            {{ format_number_to_money($product->price_sell) }}
                                        </h4>
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
                        @else
                        <h3 class="title" style="padding-top: 20px;">Không tìm thấy sản phẩm</h3>
                        @endif
                    </div>
                    <div class="clearfix">
                    </div>
                </div>
                @if (count($products) > 0)
                <div class="text-center">
                    <ul class="pagination">
                        {{ $products->links('vendor.pagination.default') }}
                    </ul>
                </div>
                @endif
            </div>
            <div class="clearfix">
            </div>
        </div>
    </div>
</div>
{{-- @vite(['resources/client/js/show-product.js']) --}}
@endsection