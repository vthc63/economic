@extends('layouts.client')
@section('content-client')
<div class="clearfix"></div>
<div class="hom-slider">
    <div class="container">
        <div id="sequence">
            <div class="sequence-prev"><i class="fa fa-angle-left"></i></div>
            <div class="sequence-next"><i class="fa fa-angle-right"></i></div>
            <ul class="sequence-canvas">
                <li class="animate-in">
                    <div class="flat-caption caption2 formLeft delay400 text-center">
                        <h1>MINT SHOP</h1>
                    </div>
                    <div class="flat-caption caption3 formLeft delay500 text-center">
                        <p>Chào mừng đến với shop thời trang của chúng tôi - nơi cung cấp các sản phẩm đa dạng và chất lượng cao. Đến với chúng tôi để tìm kiếm phong cách của bạn!</p>
                        <p>Phong cách của bạn là niềm đam mê của chúng tôi - Hãy để chúng tôi giúp bạn thể hiện nó</p>
                    </div>
                    <div class="flat-image formBottom delay200" data-duration="5" data-bottom="true"><img src="{{ asset('asset/client/images/slider-image-01.png') }}" alt=""></div>
                </li>
                <li>
                    <div class="flat-caption caption2 formLeft delay400 text-center">
                        <h1>MINT SHOP</h1>
                    </div>
                    <div class="flat-caption caption3 formLeft delay500 text-center">
                        <p>Chào mừng đến với shop thời trang của chúng tôi - nơi cung cấp các sản phẩm đa dạng và chất lượng cao. Đến với chúng tôi để tìm kiếm phong cách của bạn!</p>
                        <p>Phong cách của bạn là niềm đam mê của chúng tôi - Hãy để chúng tôi giúp bạn thể hiện nó</p>
                    </div>
                    <div class="flat-image formBottom delay200" data-bottom="true"><img src="{{ asset('asset/client/images/slider-image-03.png') }}" alt=""></div>
                </li>
            </ul>
        </div>
    </div>
    {{-- <div class="promotion-banner">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <div class="promo-box"><img src="{{ asset('asset/client/images/promotion-01.png') }}" alt=""></div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <div class="promo-box"><img src="{{ asset('asset/client/images/promotion-02.png') }}" alt=""></div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <div class="promo-box"><img src="{{ asset('asset/client/images/promotion-03.png') }}" alt=""></div>
                </div>
            </div>
        </div>
    </div> --}}
</div>
<div class="clearfix"></div>
<div class="container_fullwidth">
    <div class="container">
        <div class="clearfix"></div>
        <div class="featured-products">
            <h3 class="title">Sản Phẩm Mới Nhất</h3>
            <div class="control"></div>
            <ul>
                <li>
                <div class="row">
                    @foreach ($newProducts as $newProduct)
                        <div class="col-md-3 col-sm-6">
                            <div class="products">
                                <div class="offer">Mới Nhất</div>
                                <div class="thumbnail"><a href="{{ route('user.products_detail', $newProduct->id) }}"><img src="{{ asset("asset/client/images/products/small/$newProduct->img") }}" alt="Product Name"></a></div>
                                <div class="productname" style="height: 42px;">{{ $newProduct->name }}</div>
                                <h4 class="price">{{ format_number_to_money($newProduct->price_sell) }} VNĐ</h4>
                                <div class="productname" style="padding-bottom: 10px; padding-top: unset;">
                                    <x-avg-stars :number="$newProduct->avg_rating" />
                                    <span style="font-size: 14px;">Đã bán: {{ $newProduct->sum }}</span>
                                </div>
                                <div class="button_group"><a href="{{ route('user.products_detail', $newProduct->id) }}" class="button add-cart" type="button">Xem Chi Tiết</a></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
@endsection