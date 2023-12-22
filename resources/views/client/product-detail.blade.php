@extends('layouts.client')
@section('content-client')
<style>
  .rating .fa-star{
    color: #b1b1b1;
  }
  .preview-small{
    margin-top: unset !important;
  }

  .quantyti_sold{
    font-size: 14px !important;
  }

  .products-description div{
    font-size: 14px;
    line-height: 20px;
  }
</style>
<div class="container_fullwidth">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="products-details">
            <div class="preview_image">
              <div class="preview-small text-center">
                <img id="zoom_03" src="{{ asset("asset/client/images/products/small/$product->img") }}" data-zoom-image="{{ asset("asset/client/images/products/small/$product->img") }}" alt="">
              </div>
              <div class="thum-image">
                <ul id="gallery_01" class="prev-thum">
                  @foreach ($productColor as $color)
                    <li class="sub-img">
                      <a href="#" data-image="{{ asset("asset/client/images/products/small/$color->img") }}" data-zoom-image="{{ asset("asset/client/images/products/small/$color->img") }}">
                        <img src="{{ asset("asset/client/images/products/small/$color->img") }}" alt="">
                      </a>
                    </li>
                  @endforeach
                </ul>
                <a class="control-left" id="thum-prev" href="javascript:void(0);">
                  <i class="fa fa-chevron-left">
                  </i>
                </a>
                <a class="control-right" id="thum-next" href="javascript:void(0);">
                  <i class="fa fa-chevron-right">
                  </i>
                </a>
              </div>
            </div>
            <div class="products-description">
              <h5 class="name">
                {{ $product->name }}
              </h5>
              <p class="quantyti_sold">
                Số lượng đã bán: 
                <span class=" light-red">
                  {{ $productSold->sum ?? 0}}
                </span>
              </p>
              <p>
                {!! $product->description !!}
              </p>
              <hr class="border">
              <div class="price">
                Price : 
                <span class="new_price">
                  {{ format_number_to_money($product->price_sell) }}
                  <sup>
                    VNĐ
                  </sup>
                </span>
              </div>
              <hr class="border">
              <form action="{{ route('cart.store') }}" method="POST">
                @csrf
                <div class="wided row">
                  <div class="col-md-3 wided-box">
                    Màu &nbsp;&nbsp;: 
                    <select id="data-color">
                      @foreach ($productColor as $color)
                        <option value="{{ $color->id }}">
                          {{ $color->color_name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-3 wided-box">
                    Kích thước &nbsp;&nbsp;: 
                    <select id="data-size" data-sizes="{{ json_encode($productSize) }}" name="id">
                      
                    </select>
                  </div>
                  <div class="col-md-3 wided-box">
                    <div style="display: flex; align-items: center; height: 30px;">
                      Số lượng còn &nbsp;&nbsp;: <span id="quantity_remain" style="margin-left: 10px;"></span>
                    </div>
                  </div>
                  <div class="col-md-3 wided-box" style="display: flex">
                    <div style="display: flex; align-items: center;">
                      <span>Số lượng&nbsp;&nbsp;:</span>
                    </div>
                    <div style="margin-left: 10px;">
                      <input type="number" value="1" min="1" name="quantity" style="max-width: 70px; height: 30px;">
                    </div>
                  </div>
                  <div class="col-md-12 wided-box text-center">
                    <button class="button add-to-cart-btn" >
                      Thêm Vào Giỏ Hàng
                    </button>
                  </div>
                </div>
              </form>
              <div class="clearfix">
              </div>
            </div>
          </div>
          <div class="clearfix">
          </div>
          <div id="productsDetails" class="hot-products">
            <h3 class="title">
              Sản Phẩm Liên Quan
            </h3>
            <div class="control">
              <a id="prev_hot" class="prev" href="#">
                &lt;
              </a>
              <a id="next_hot" class="next" href="#">
                &gt;
              </a>
            </div>
            <ul>
              <li>
                <div class="row">
                  @foreach ($relatedProducts as $relatedProduct)
                    <div class="col-md-3 col-sm-4">
                      <div class="products">
                        <div class="thumbnail text-center">
                          <img src="{{ asset("asset/client/images/products/small/$relatedProduct->img") }}" alt="Product Name">
                        </div>
                        <div class="productname">
                          {{ $relatedProduct->name }}
                        </div>
                        <h4 class="price">
                          {{ format_number_to_money($relatedProduct->price_sell) }} VNĐ
                        </h4>
                        <div class="productname" style="padding-bottom: 10px; padding-top: unset;">
                          <x-avg-stars :number="$relatedProduct->avg_rating" />
                          <span style="font-size: 14px;">Đã bán: {{ $relatedProduct->sum }}</span>
                        </div>
                        <div class="button_group">
                          <a href="{{ route('user.products_detail', $relatedProduct->id) }}" class="button add-cart" type="button">Xem Chi Tiết</a>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              </li>
            </ul>
          </div>
          <div class="clearfix">
          <div class="tab-box">
            <div class="title-review">
              <ul>
                <li>
                  <a href="#Reviews">
                    Đánh Giá Sản Phẩm
                  </a>
                </li>
              </ul>
            </div>
            <div class="tab-content-wrap">
              <div class="tab-content">
                <form method="POST" action="{{ route('product_review.store', $product->id) }}">
                  @csrf
                  <div class="row">
                    @if ($checkReviewProduct)
                      <div class="col-md-6 col-sm-6">
                        <div class="form-row">
                          <label class="review-lable">
                            Chọn sao cho sản phẩm
                          </label>
                          <div class="rating">
                              <input class="star" type="radio" hidden id="star1" name="rating" value="1" />
                              <label for="star1" title="Poor" id="icon-star1">
                                  <i class="fas fa-star"></i>
                              </label>
                              <input class="star" type="radio" hidden id="star2" name="rating" value="2" />
                              <label for="star2" title="Fair" id="icon-star2">
                                  <i class="fas fa-star"></i>
                              </label>
                              <input class="star" type="radio" hidden id="star3" name="rating" value="3" />
                              <label for="star3" title="Good" id="icon-star3">
                                  <i class="fas fa-star"></i>
                              </label>
                              <input class="star" type="radio" hidden id="star4" name="rating" value="4" />
                              <label for="star4" title="Very Good" id="icon-star4">
                                  <i class="fas fa-star"></i>
                              </label>
                              <input class="star" type="radio" hidden id="star5" name="rating" value="5" />
                              <label for="star5" title="Excellent" id="icon-star5">
                                  <i class="fas fa-star"></i>
                              </label>
                          </div>
                        </div>
                        <div class="form-row">
                          <label class="review-lable">
                            Nội dung đánh giá
                          </label>
                          <textarea style="width: 100%;" name="content" rows="7" >
                          </textarea>
                        </div>
                        <div class="form-row">
                          <input type="submit" value="Đánh Giá" class="button">
                        </div>
                      </div>
                    @endif
                    <div class="col-md-6 col-sm-6">
                      <div class="form-row row">
                        <div class="col-md-5">
                          <label class="title-avg-star review-lable">Đánh giá trung bình</label>
                          <div class="avg-star">
                            @for($i = 1; $i <= floor($avgRating); $i++)
                              <i class="fas fa-star"></i>
                            @endfor
                            @if (! is_int($avgRating))
                              <i class="fas fa-star-half-alt"></i>
                            @endif
                          </div>
                          <h4 class="number-avg-star">{{ number_format($avgRating, 1) }}</h4>
                        </div>
                        <div class="col-md-6">
                          <label class="title-avg-star review-lable">10 Đánh giá</label>
                          @for ($i = 5; $i >= 1; $i--)
                            <div class="avg-star">
                              <x-stars :number="$i" />
                              <span class="parameter-review">({{ $ratingStatistics[$i] }})</span>
                            </div>
                          @endfor
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="tab-box">
            <div class="title-review">
              <ul>
                <li>
                  <a href="#Reviews">
                    Các Đánh Giá Sản Phẩm
                  </a>
                </li>
              </ul>
            </div>
            <div class="tab-content-wrap">
              <div class="tab-content row">
                @if (count($productReviews) > 0)
                  <div class="review__comment-header">
                    <div class="row">
                      <div class="col-sm-4 review__comment-header--title">
                        Thành viên
                      </div>
                      <div class="col-sm-8 review__comment-header--title">
                        Nội dung đánh giá
                      </div>
                    </div>
                  </div>
                  <div class="review__comment-list" style="padding-top: 30px;">
                    <div class="row">
                      @foreach ($productReviews as $productReview)
                        <div class="col-sm-4">
                          <span class="review__comment-author">{{ $productReview->user_name }}</span>
                          <div class="review__comment-time">
                            <span>{{ $productReview->created_at }}</span>
                          </div>
                        </div>
                        <div class="col-sm-8">
                          <div class="review__comment-rating">
                            <x-stars number="{{ $productReview->rating }}"/>
                          </div>
                          <div class="review__comment-content">
                            <p>
                              {{ $productReview->content }}
                            </p>
                          </div>
                        </div>
                        <div class="col-sm-12 review_comment-line"></div>
                      @endforeach
                    </div>
                  </div>
                @else 
                  <p class="text-center review-comment-null">Chưa có đánh giá nào</p>
                @endif
              </div>
            </div>
          </div>
          @if (count($productReviews) > 0)
          <div class="text-center">
              <ul class="pagination">
                  {{ $productReviews->links('vendor.pagination.default') }}
              </ul>
          </div>
          @endif
          <div class="clearfix">
          </div>
          </div>
        </div>
      </div>
      <div class="clearfix">
      </div>
    </div>
</div>
@vite(['resources/client/js/product-detail.js', 'resources/client/css/product-detail.css', 'resources/client/css/product-review.css'])
@endsection