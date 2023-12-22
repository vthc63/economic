<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * @var CartService
     */
    private $cartService;

    /**
     * CartController constructor.
     *
     * @param HomeService $cartService
     */
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    public function index()
    {
        return view('client.cart', $this->cartService->index());
    }

    public function store(Request $request)
    {
        return $this->cartService->store($request);
    }

    public function update(Request $request)
    {
        return $this->cartService->update($request);
    }

    public function delete($id)
    {
        return $this->cartService->delete($id);
    }

    public function clearAllCart()
    {
        $this->cartService->clearAllCart();
    }
}
