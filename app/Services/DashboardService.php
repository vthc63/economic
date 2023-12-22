<?php

namespace App\Services;

use App\Repository\Eloquent\OrderRepository;
use App\Repository\Eloquent\UserRepository;
use Carbon\Carbon;

class DashboardService 
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * DashboardService constructor.
     *
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository, UserRepository $userRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //tổng doanh thu
        $revenue = $this->orderRepository->getRevenue();
        //tổng đơn hàng
        $orders = $this->orderRepository->getOrderTotal();
        //sản phẩm tồn kho
        $products = $this->orderRepository->getProductTotal();
        //lợi nhuận
        $profit =  $this->orderRepository->getProfit();
        //tổng khách hàng
        $users = count($this->userRepository->all());
        //tổng nhân sự
        $admins = count($this->userRepository->admins());
        //thống kê theo ngày trong tháng
        $salesStatisticsByDays = $this->orderRepository->salesStatisticsByDay();
        // mấy tháng hiện tại
        $month = Carbon::now()->month;
        //lấy năm hiện tại
        $year = Carbon::now()->year;

        // lấy số ngày trong tháng hiện tại
        $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;

        $daysArray = [];
        $parameters = [];
        //lấy danh thu bán được 1 ngày của tháng hiện tại
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $daysArray[] = $day;// daysArray[1] 
            $check = false;
            for ($i = 0; $i < count($salesStatisticsByDays); $i++) {
                if ($salesStatisticsByDays[$i]->day == $day) {
                    $check = true;
                    $parameters[$day - 1] = $salesStatisticsByDays[$i]->total;
                }
            }
            if ($check == false) {
                $parameters[$day - 1] = 0;
            }
        }

        //lấy sản phẩm bán chạy
        $bestSellProducts = $this->orderRepository->bestSellProducts();
        $labelBestSellProduct = [];
        $parameterBestSellProduct = [];
        foreach ($bestSellProducts as $product) {
            $labelBestSellProduct[] = $product->name;
            $parameterBestSellProduct[] = $product->sum;
        }

        // lấy sản phẩm được đánh giá nhiều nhất
        $bestProductReviews = $this->orderRepository->bestProductReviews();
        $labelBestProductReview = [];
        $parameterBestProductReview = [];
        foreach ($bestProductReviews as $product) {
            $labelBestProductReview[] = $product->name;
            $parameterBestProductReview[] = $product->sum;
        }
        // lấy đơn hàng gần đây
        $list = $this->orderRepository->getNewOrders();
        $tableCrud = [
            'headers' => [
                [
                    'text' => 'Mã HD',
                    'key' => 'id',
                ],
                [
                    'text' => 'Tên KH',
                    'key' => 'user_name',
                ],
                [
                    'text' => 'Email',
                    'key' => 'user_email',
                ],
                [
                    'text' => 'Tổng Tiền',
                    'key' => 'total_money',
                    'format' => true,
                ],
                [
                    'text' => 'PT Thanh Toán',
                    'key' => 'payment_name',
                ],
                [
                    'text' => 'Ngày Đặt Hàng',
                    'key' => 'created_at',
                ],
                [
                    'text' => 'Trạng Thái',
                    'key' => 'order_status',
                    'status' => [
                        [
                            'text' => 'Chờ Xử Lý',
                            'value' => 0,
                            'class' => 'badge badge-warning'
                        ],
                        [
                            'text' => 'Đang Giao Hàng',
                            'value' => 1,
                            'class' => 'badge badge-info'
                        ],
                        [
                            'text' => 'Đã Hủy',
                            'value' => 2,
                            'class' => 'badge badge-danger'
                        ],
                        [
                            'text' => 'Đã Nhận Hàng',
                            'value' => 3,
                            'class' => 'badge badge-success'
                        ],
                    ],
                ],
            ],
            'actions' => [
                'text'          => "Thao Tác",
                'create'        => false,
                'createExcel'   => false,
                'edit'          => true,
                'deleteAll'     => false,
                'delete'        => true,
                'viewDetail'    => false,
            ],
            'routes' => [
                'delete' => 'admin.orders_delete',
                'edit' => 'admin.orders_edit',
            ],
            'list' => $list,
        ];
        return [
            'title' => TextLayoutTitle("dashboard"),
            'revenue' => $revenue,
            'orders' => $orders,
            'products' => $products,
            'profit' => $profit,
            'users' => $users,
            'days' => json_encode($daysArray),
            'parameters' => json_encode($parameters),
            'year' => $year,
            'month' => $month,
            'tableCrud' => $tableCrud,
            'labelBestSellProduct' => json_encode($labelBestSellProduct),
            'parameterBestSellProduct' => json_encode($parameterBestSellProduct),
            'labelBestProductReview' => json_encode($labelBestProductReview),
            'parameterBestProductReview' => json_encode($parameterBestProductReview),
            'admins' => $admins
        ];
    }

}
?>