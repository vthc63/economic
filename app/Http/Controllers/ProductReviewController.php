<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductReviewRequest;
use App\Models\Product;
use App\Services\ProductReviewService;

class ProductReviewController extends Controller
{
    /**
     * @var ProductReviewService
     */
    private $productReviewService;

    /**
     * ProductReviewController constructor.
     *
     * @param ProductReviewService $productReviewService
     */
    public function __construct(ProductReviewService $productReviewService)
    {
        $this->productReviewService = $productReviewService;
    }

    public function store(ProductReviewRequest $request, Product $product)
    {
        return $this->productReviewService->store($request, $product);
    }
}
