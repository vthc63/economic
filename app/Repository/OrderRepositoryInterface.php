<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface OrderRepositoryInterface
 * @package App\Repositories
 */
interface OrderRepositoryInterface
{
    /**
     * Get all orders 
     */
    public function getAllOrders();

    /**
     * Get orders detail
     */
    public function getOrderDetail($id);

    /**
     * Get customer information of the order
     */
    public function getInfoUserOfOrder($id);

    /**
     * Get revenue
     */
    public function getRevenue();

    /**
     * Get orders total
     */
    public function getOrderTotal();
    
    /**
     * Get orders total
     */
    public function getProductTotal();

    /**
     * Get total number of products sold
     */
    public function getTotalProductSold();

    /**
     * Get profit
     */
    public function getProfit();

    /**
     * Sales statistics by day
     */
    public function salesStatisticsByDay();

    /**
     * Get 10 new orders
     */
    public function getNewOrders();

    /**
     * Get orders by user
     * @param int|string $id
     */
    public function getOrderByUser($id);
}
?>