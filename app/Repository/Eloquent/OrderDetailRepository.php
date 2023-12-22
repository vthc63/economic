<?php

namespace App\Repository\Eloquent;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Repository\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;

/**
 * Class OrderDetailRepository
 * @package App\Repositories\Eloquent
 */
class OrderDetailRepository extends BaseRepository
{
    /**
     * OrderDetailRepository constructor.
     *
     * @param OrderDetail $orderDetail
     */
    public function __construct(OrderDetail $orderDetail)
    {
        parent::__construct($orderDetail);
    }

}

?>