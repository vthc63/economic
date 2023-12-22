<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderHistoryService;
use App\Services\OrderService;

class OrderHistoryController extends Controller
{
    /**
     * @var OrderHistoryService
     */
    private $orderHistoryService;

    /**
     * OrderHistoryController constructor.
     *
     * @param OrderHistoryService $orderHistoryService
     */
    public function __construct(OrderHistoryService $orderHistoryService)
    {
        $this->orderHistoryService = $orderHistoryService;
    }

    /**
     * Displays home website.
     *
     * @return \Illuminate\View\View
     */
    public function index() 
    {
        return view('client.order-history', $this->orderHistoryService->index());
    }

    public function show(Order $order)
    {
        return view('client.order-history-detail', $this->orderHistoryService->show($order));
    }

    public function update(Order $order)
    {
        return $this->orderHistoryService->update($order);
    }
}
