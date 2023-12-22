<?php

namespace App\Services;

use App\Helpers\TextSystemConst;
use App\Http\Requests\ProductReviewRequest;
use App\Models\Product;
use App\Repository\Eloquent\ProductReviewRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductReviewService 
{
    /**
     * @var ProductReviewRepository
     */
    private $productReviewReprository;

    /**
     * ProductReviewService constructor.
     *
     * @param ProductReviewRepository $productReviewReprository
     */
    public function __construct(ProductReviewRepository $productReviewReprository)
    {
        $this->productReviewReprository = $productReviewReprository;
    }
    
    /** 
     * store the admin in the database.
     * @param App\Http\Requests\Admin\StoreCategoryRequest $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function store(ProductReviewRequest $request, Product $product)
    {
        try {
            $data = $request->validated();
            if ($this->checkProductReview($product)){
                return back()->with('error', "Đánh giá thất bại vui lòng thử lại");
            }
            $data['user_id'] = Auth::user()->id;
            $data['product_id'] = $product->id;
            $this->productReviewReprository->create($data);
            return back()->with('success', "Đánh giá sản phẩm thành công");;
        } catch (Exception $e) {
            Log::error($e);
            return back()->with('error', TextSystemConst::CREATE_FAILED);
        }
    }

    public function checkProductReview(Product $product)
    {
        if (! Auth::check()) {
            return false;
        }
        $user = Auth::user();
        if (count($this->productReviewReprository->checkUserBuyProduct($product->id, $user->id)) <= 0) {
            return false;
        }

        if ($this->productReviewReprository->checkUserProductReview($product->id, $user->id) >= 1) {
            return false;
        }

        return true;
    }

     /** 
     * delete the user in the database.
     * @param Illuminate\Http\Request; $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        try{
            if($this->productReviewReprository->delete($this->productReviewReprository->find($request->id))) {
                return response()->json(['status' => 'success', 'message' => TextSystemConst::DELETE_SUCCESS], 200);
            }

            return response()->json(['status' => 'failed', 'message' => TextSystemConst::DELETE_FAILED], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json(['status' => 'error', 'message' => TextSystemConst::SYSTEM_ERROR], 200);
        }
    }
}
?>