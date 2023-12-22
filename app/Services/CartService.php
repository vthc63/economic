<?php

namespace App\Services;

use App\Helpers\TextSystemConst;
use App\Repository\Eloquent\ProductSizeRepository;
use Illuminate\Http\Request;

class CartService 
{
     /**
     * @var ProductSizeRepository
     */
    private $productSizeRepository;

    /**
     * CartService constructor.
     *
     * @param ProductSizeRepository $categoryRepository
     */
    public function __construct(ProductSizeRepository $productSizeRepository)
    {
        $this->productSizeRepository = $productSizeRepository;
    }
    
    public function index()
    {

        return ['carts' => \Cart::getContent()];
    }

    public function store(Request $request)
    {
        // lấy thông tin sản phẩm
        $product = $this->productSizeRepository->getProductSize($request->id);
        // kiểm tra xem sản phẩm được thêm vào giỏ hàng có tồn tại không
        if (! $product) {
            return redirect()->route('user.home');
        }
        // lấy toàn bộ sản phẩm có trong giỏ hàng
        $carts = \Cart::getContent()->toArray();
        
        //Nếu giỏ hàng không rỗng và kiểm tra xem sản phẩm được thêm có tồn tại trong giỏ hàng chưa
        if (! empty($carts) && array_key_exists($request->id, $carts)) {
            // khi thêm vào nếu số lượng vượt quá trong kho thì sẽ báo lỗi
            if ($carts[$request->id]['quantity'] + $request->quantity > $product->products_size_quantity) {
                return back()->with('error', TextSystemConst::ADD_CART_ERROR_QUANTITY);
            }
        }
        
        //nếu người dùng thêm sản phẩm lớn hơn với số lượng kho thì báo lỗi
        if ($request->quantity > $product->products_size_quantity) {
            return back()->with('error', TextSystemConst::ADD_CART_ERROR_QUANTITY);
        }
        // thêm sản phẩm vào giỏ hàng hoặc cập số lượng nếu như sản phảm đó đã tồn trong giỏ hàng
        \Cart::add([
            'id' => $request->id,
            'name' => $product->product_name,
            'price' => $product->product_price_sell,
            'quantity' => $request->quantity,
            'attributes' => array(
                'image' => $product->product_img,
                'size' => $product->size_name,
                'color' => $product->color_name,
            )
        ]);

        // chuyển hướng người dùng đến trang giỏ hàng
        return redirect()->route('cart.index');
    }

    // cập nhật giỏ hàng
    public function update(Request $request)
    {
        $product = $this->productSizeRepository->getProductSize($request->id);
        // nếu người dùng cập nhật số lượng hơn trong kho thì báo lỗi
        if($request->quantity > $product->products_size_quantity) {
            return back()->with('error', TextSystemConst::ADD_CART_ERROR_QUANTITY);
        }

        // cập nhật lại số lượng trong kho
        \Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ],
            ]
        );

        // chuyển hướng dùng về lại trang giỏ hàng
        return redirect()->route('cart.index');
    }

    public function delete($id)
    {
        \Cart::remove($id);

        return redirect()->route('cart.index');
    }

    public function clearAllCart()
    {
        return redirect()->route('cart.index');
    }
}
?>