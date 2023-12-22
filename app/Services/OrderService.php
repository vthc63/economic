<?php

namespace App\Services;

use App\Helpers\TextSystemConst;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductSize;
use App\Repository\Eloquent\OrderRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OrderService 
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * OrderService constructor.
     *
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get list order
        $list = $this->orderRepository->getAllOrders();
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
                    'text' => 'Trạng Thái Đơn',
                    'key' => 'order_status',
                    'status' => [
                        [
                            'text' => 'Chờ Xử Lý',
                            'value' => Order::STATUS_ORDER['wait'],
                            'class' => 'badge badge-warning'
                        ],
                        [
                            'text' => 'Đang Giao Hàng',
                            'value' => Order::STATUS_ORDER['transporting'],
                            'class' => 'badge badge-info'
                        ],
                        [
                            'text' => 'Đã Hủy',
                            'value' => Order::STATUS_ORDER['cancel'],
                            'class' => 'badge badge-danger'
                        ],
                        [
                            'text' => 'Đã Nhận Hàng',
                            'value' => Order::STATUS_ORDER['received'],
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
            'title' => TextLayoutTitle("order"),
            'tableCrud' => $tableCrud,
        ];
    }

    public function edit(Order $order)
    {
        $infoUserOfOrder = $this->orderRepository->getInfoUserOfOrder($order->id);
        $infomationUser['id'] = $infoUserOfOrder->user_id;
        $infomationUser['name'] = $infoUserOfOrder->user_name;
        $infomationUser['email'] = $infoUserOfOrder->user_email;
        $infomationUser['phone_number'] = $infoUserOfOrder->user_phone_number;
        $infomationUser['apartment_number'] = $infoUserOfOrder->address_apartment_number;
        $infomationUser['payment_name'] = $infoUserOfOrder->payment_name;
        $infomationUser['orders_transport_fee'] = $infoUserOfOrder->orders_transport_fee;
        $response = Http::withHeaders([
            'token' => '24d5b95c-7cde-11ed-be76-3233f989b8f3'
        ])->get('https://online-gateway.ghn.vn/shiip/public-api/master-data/province');
        $data = json_decode($response->body(), true);
        foreach ($data['data'] as $item) {
            if ($infoUserOfOrder->address_city == $item['ProvinceID']) {
                $infomationUser['city'] = $item['NameExtension'][1];
            }
        }
        $response = Http::withHeaders([
            'token' => '24d5b95c-7cde-11ed-be76-3233f989b8f3'
        ])->get('https://online-gateway.ghn.vn/shiip/public-api/master-data/district', [
            'province_id' => $infoUserOfOrder->address_city,
        ]);
        $data = json_decode($response->body(), true);
        foreach ($data['data'] as $item) {
            if ($infoUserOfOrder->address_district == $item['DistrictID']) {
                $infomationUser['district'] = $item['DistrictName'];
            }
        }

        $response = Http::withHeaders([
            'token' => '24d5b95c-7cde-11ed-be76-3233f989b8f3'
        ])->get('https://online-gateway.ghn.vn/shiip/public-api/master-data/ward', [
            'district_id' => $infoUserOfOrder->address_district,
        ]);
        $data = json_decode($response->body(), true);
        foreach ($data['data'] as $item) {
            if ($infoUserOfOrder->address_ward == $item['WardCode']) {
                $infomationUser['ward'] = $item['NameExtension'][0];
            }
        }
        return [
            'title' => TextLayoutTitle("order_detail"),
            'order' => $order,
            'infomation_user' => $infomationUser,
            'order_details' => $this->orderRepository->getOrderDetail($order->id)
        ];
    }

    public function update(Order $order ,Request $request)
    {
        try {
            $data = $request->all();
            // hoàn trả lại số lượng
            if ($request->order_status == 2) {
                // lấy những phẩm thuộc đơn hàng bị hủy
                $orderDetails = OrderDetail::where('order_id', $order->id)->get();
                // duyệt qua tất cả sản phẩm và trả số lượng ban đầu
                foreach($orderDetails as $orderDetail) {
                    // tìm cái sản phẩm
                    $productSize = ProductSize::where('id', $orderDetail->product_size_id)->first();
                    // hoàn trả lại số lượng
                    $productSize->update(['quantity' => $productSize->quantity + $orderDetail->quantity]);
                }
            }
            // cập nhật lại thông tin đơn hàng gồm trạng thái và ghi chú của đơn hàng
            $this->orderRepository->update($order, $data);
            return redirect()->route('admin.orders_index')->with('success', TextSystemConst::ORDER_PROCESSING);
        } catch (Exception $e) {
            return redirect()->route('admin.orders_index')->with('error', $e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try{
            if($this->orderRepository->delete($this->orderRepository->find($request->id))) {
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