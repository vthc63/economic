<?php

namespace App\Repository\Eloquent;

use App\Models\Order;
use App\Repository\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;

/**
 * Class OrderRepository
 * @package App\Repositories\Eloquent
 */
class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    /**
     * OrderRepository constructor.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        parent::__construct($order);
    }

    /**
     * Get all orders 
     */
    public function getAllOrders()
    {
        return DB::table('orders')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->join('payments', 'orders.payment_id', '=', 'payments.id')
        ->select('users.name as user_name', 'users.email as user_email', 'payments.name as payment_name', 'orders.*')
        ->orderByDesc('orders.created_at')
        ->whereNull('orders.deleted_at')
        ->get();
    }

    /**
     * Get orders detail
     */
    public function getOrderDetail($id)
    {
        return DB::table('orders')
        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
        ->join('products_size', 'order_details.product_size_id', '=', 'products_size.id')
        ->join('sizes', 'products_size.size_id', '=', 'sizes.id')
        ->join('products_color', 'products_size.product_color_id', '=', 'products_color.id')
        ->join('colors', 'products_color.color_id', '=', 'colors.id')
        ->join('products', 'products_color.product_id', '=', 'products.id')
        ->select(
            'orders.*',
            'order_details.unit_price',
            'order_details.quantity',
            'sizes.name as size_name',
            'products_color.img as products_color_img',
            'colors.name as color_name',
            'products.name as product_name',
            'products.id as product_id',
            'products.img as product_img'
        )
        ->where('orders.id', $id)
        ->get();
    }

    /**
     * Get customer information of the order
     */
    public function getInfoUserOfOrder($id)
    {
        return DB::table('orders')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->join('addresses', 'users.id', '=', 'addresses.user_id')
        ->join('payments', 'orders.payment_id', '=', 'payments.id')
        ->select(
            'users.id as user_id',
            'users.name as user_name',
            'users.email as user_email',
            'users.phone_number as user_phone_number',
            'addresses.city as address_city',
            'addresses.district as address_district',
            'addresses.ward as address_ward',
            'addresses.apartment_number as address_apartment_number',
            'payments.name as payment_name',
            'orders.transport_fee as orders_transport_fee',
        )
        ->where('orders.id', $id)
        ->first();
    }

    public function getRevenue()
    {
        return DB::table('orders')->where('order_status', 3)->sum('total_money');
    }

    public function getOrderTotal()
    {
        return DB::table('orders')->where('order_status', '!=', 2)->count();
    }

    /**
     * Get orders total
     */
    public function getProductTotal()
    {
        return DB::table('products_size')
        ->join('products_color', 'products_color.id', '=', 'products_size.product_color_id')
        ->join('products', 'products.id', '=', 'products_color.product_id')
        ->where('products_color.deleted_at', null)
        ->where('products.deleted_at', null)
        ->sum('products_size.quantity');
    }

    /**
     * Get total number of products sold
     */
    public function getTotalProductSold()
    {
        return DB::table('orders')
        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
        ->where('orders.order_status', 3)
        ->sum('order_details.quantity');
    }

    /**
     * Get profit
     */
    public function getProfit()
    {
        return DB::select('
            select sum(order_details.quantity * order_details.unit_price) - sum(order_details.quantity * products.price_import) as profit from products 
            join products_color on products.id = products_color.product_id
            join products_size on products_color.id = products_size.product_color_id
            join order_details on products_size.id = order_details.product_size_id
            join orders on orders.id = order_details.order_id
            where orders.order_status = 3;
        ')[0]->profit ?? 0;
        ;
    }

    /**
     * Sales statistics by day
     */
    public function salesStatisticsByDay()
    {
        return DB::select('
            select day(created_at) as day, sum(total_money) as total from orders
            where month(orders.created_at) = month(current_date())
            and year(orders.created_at) = year(current_date())
            and orders.order_status = 3
            group by day(orders.created_at)
            ;
        ');
        ;
    }

    /**
     * Get 10 new orders
     */
    public function getNewOrders()
    {
        return DB::table('orders')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->join('payments', 'orders.payment_id', '=', 'payments.id')
        ->select('users.name as user_name', 'users.email as user_email', 'payments.name as payment_name', 'orders.*')
        ->whereNull('orders.deleted_at')
        ->orderByDesc('orders.id')
        ->limit(10)
        ->get();
    }

    /**
     * Get orders by user
     * @param int|string $id
     */
    public function getOrderByUser($id)
    {
        return DB::table('orders')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->join('payments', 'orders.payment_id', '=', 'payments.id')
        ->select('users.name as user_name', 'users.email as user_email', 'payments.name as payment_name', 'orders.*')
        ->where('user_id', $id)
        ->whereNull('orders.deleted_at')
        ->orderByDesc('orders.id')
        ->paginate(Order::ORDER_NUMBER_ITEM['history']);
    }

    public function bestSellProducts()
    {
        return DB::select('
            select sum(order_details.quantity) as sum, products.id, products.name from orders join order_details on orders.id = order_details.order_id
            join products_size on products_size.id = order_details.product_size_id
            join products_color on products_color.id = products_size.product_color_id
            join products on products.id = products_color.product_id
            where orders.order_status = 3
            group by products.id, products.name
            order by sum desc
            limit 10
        ;
    ');
    }

    public function bestProductReviews()
    {
        return DB::select('
            select count(*) as sum, products.id, products.name from product_reviews join products on products.id = product_reviews.product_id
            group by products.id, products.name
            order by sum desc
            limit 10;
        ');
    }
}

?>