<?php

namespace App\Services;

use App\Models\Category;
use App\Repository\Eloquent\BrandRepository;
use App\Repository\Eloquent\CategoryRepository;
use App\Repository\Eloquent\ProductRepository;
use App\Repository\Eloquent\ProductReviewRepository;
use Illuminate\Http\Request;

class SearchService 
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
     * SearchService constructor.
     *
     * @param ProductRepository $productRepository
     */
    public function __construct(
        ProductRepository $productRepository, 
        CategoryRepository $categoryRepository,
        BrandRepository $brandRepository,
        ProductReviewRepository $productReviewRepository,
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
    public function search(Request $request)
    {
        $categories = Category::where('parent_id', '!=', 0)->get();
        $brands = $this->brandRepository->all();
        
        $keyword = $request->keyword ?? null;
        $category = $request->category ?? null;
        $minPrice = $request->min_price ?? null;
        $maxPrice = $request->max_price ?? null;
        $brand = $request->brand ?? null;
    
        $products = $this->productRepository->getProductSearch($keyword, $category, $minPrice, $maxPrice, $brand);
        foreach($products as $key => $product) {
            $products[$key]->avg_rating = $this->productReviewRepository->avgRatingProduct($product->id)->avg_rating ?? 0;
            $products[$key]->sum = $this->productRepository->getQuantityBuyProduct($product->id);
        }

        //sort by avg rating
        for ($i = 0; $i < count($products) - 1; $i++) {
            for ($j = $i + 1; $j < count($products); $j++) {
                if ($products[$i]->avg_rating < $products[$j]->avg_rating) {
                    $temp = $products[$i];
                    $products[$i] = $products[$j];
                    $products[$j] = $temp;
                }
            }
        }

        // sort by quantity sold
        for ($i = 0; $i < count($products) - 1; $i++) {
            for ($j = $i + 1; $j < count($products); $j++) {
                if ($products[$i]->sum < $products[$j]->sum) {
                    $temp = $products[$i];
                    $products[$i] = $products[$j];
                    $products[$j] = $temp;
                }
            }
        }
        return [
            'contentSearch' => $request->keyword,
            'products' => $products,
            'keyword' => $keyword,
            'category' => $category,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'brand' => $brand,
            'categories' => $categories,
            'brands' => $brands,
        ];
    }
}
?>