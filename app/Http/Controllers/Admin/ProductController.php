<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductColorRequest;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\StoreSizeProductRequest;
use App\Http\Requests\Admin\UpdateProductColorRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Http\Requests\Admin\UpdateSizeProductRequest;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    /**
     * @var ProductService
     */
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService =$productService;
    }

    public function index()
    {
        return view('admin.product.index', $this->productService->index());
    }

    public function create()
    {
        return view('admin.product.create', $this->productService->create());
    }

    public function store(StoreProductRequest $request)
    {
        return $this->productService->store($request);
    }

    public function edit(Product $product)
    {
        return view('admin.product.edit', $this->productService->edit($product));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        return $this->productService->update($request, $product);
    }

    public function delete(Request $request)
    {
        return $this->productService->delete($request);
    }

    public function getCategoryByParent(Request $request)
    {
        return response()->json($this->productService->getCategoryByParent($request), 200);
    }

    public function createColor(Product $product)
    {
        return view('admin.product.color', $this->productService->createColor($product));
    }

    public function storeColor(StoreProductColorRequest $request, Product $product)
    {
       return $this->productService->storeColor($request, $product);
    }

    public function editColor(ProductColor $productColor)
    {
        return $this->productService->editColor($productColor);
    }

    public function updateColor(UpdateProductColorRequest $request, ProductColor $productColor)
    {
        return $this->productService->updateColor($request, $productColor);
    }
    
    public function deleteColor(ProductColor $productColor)
    {
        return $this->productService->deleteColor($productColor);
    }

    public function createSize(Product $product)
    {
        return view('admin.product.size', $this->productService->createSize($product));
    }

    public function getSizeByProductColor(Request $request)
    {
        return $this->productService->getSizeByProductColor($request);
    }

    public function getSizeByProductColorEdit(ProductSize $productSize)
    {
        return $this->productService->getSizeByProductColorEdit($productSize);
    }

    public function storeSizeProduct(StoreSizeProductRequest $request, Product $product)
    {
        return $this->productService->storeSizeProduct($request, $product);
    }

    public function deleteSizeProduct(ProductSize $productSize)
    {
        return $this->productService->deleteSizeProduct($productSize);
    }

    public function editSizeProduct(ProductSize $productSize, Product $product)
    {
        return $this->productService->editSizeProduct($productSize, $product);
    }

    public function updateSizeProduct(ProductSize $productSize, Product $product, UpdateSizeProductRequest $request)
    {
        return $this->productService->updateSizeProduct($productSize, $product, $request);
    }
}
