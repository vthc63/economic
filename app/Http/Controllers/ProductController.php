<?php

namespace App\Http\Controllers;

use App\Services\ShowProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @var ShowProductService $showProductService
     */
    private $showProductService;

    /**
     * ProductController constructor.
     *
     * @param ShowProductService $showProductService
     */
    public function __construct(ShowProductService $showProductService)
    {
        $this->showProductService = $showProductService;
    }
    /**
     * Displays home website.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request, $slug) 
    {
        return view('client.show-product', $this->showProductService->index($request, $slug));
    }
}
