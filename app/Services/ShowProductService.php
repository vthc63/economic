<?php

namespace App\Services;

use App\Repository\Eloquent\BrandRepository;
use App\Repository\Eloquent\CategoryRepository;
use App\Repository\Eloquent\ProductRepository;
use App\Repository\Eloquent\ProductReviewRepository;
use Illuminate\Http\Request;

class ShowProductService 
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var BrandRepository
     */
    private $brandRepository;

    /**
     * @var ProductReviewRepository
     */
    private $productReviewRepository;

    /**
     * ShowProductService constructor.
     *
     * @param ProductRepository $productRepository
     */
    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        BrandRepository $brandRepository,
        ProductReviewRepository $productReviewRepository
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->brandRepository = $brandRepository;
        $this->productReviewRepository = $productReviewRepository;
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $slug)
    {
        $categoryParent = $this->categoryRepository->whereFirst(['slug' => $slug])
        ;
        if (! $categoryParent) {
            abort(404);
        }

        $categories = $this->categoryRepository->where(['parent_id' => $categoryParent->id]);
        $categorySlug = $request->category_slug ?? null;

        if (! $categorySlug && count($categories) > 0) {
            $categorySlug = $categories[0]->slug;
        }

        $filterBrand = $request->brand_id ?? null;
        $filterMinPrice = $request->min_price ?? null;
        $filterMaxPrice = $request->max_price ?? null;

        // get products
        $products = $this->productRepository->getProductBySlug($categorySlug, $filterBrand, $filterMinPrice, $filterMaxPrice);
        
        // get quantity sold and avg rating
        foreach($products as $key => $product) {
            $products[$key]->avg_rating = $this->productReviewRepository->avgRatingProduct($product->id)->avg_rating ?? 0;
            $products[$key]->sum = $this->productRepository->getQuantityBuyProduct($product->id);
        }

        // get all brands
        $brands = $this->brandRepository->all();

        return [
            'categories' => $categories,
            'products' => $products,
            'brands' =>$brands,
            'request' => $request,
            'categorySlug' => $categorySlug,
        ];
    }
}
?>