<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\HomeService;
use App\Services\ProductDetailService;

class ProductDetailController extends Controller
{
    /**
     * @var ProductDetailService
     */
    private $productDetailService;

    /**
     * ProductDetailService constructor.
     *
     * @param ProductDetailController $productDetailService
     */
    public function __construct(ProductDetailService $productDetailService)
    {
        $this->productDetailService = $productDetailService;
    }
    /**
     * Displays home website.
     *
     * @return \Illuminate\View\View
     */
    public function show(Product $product) 
    {
        return view('client.product-detail', $this->productDetailService->show($product));
    }
}
