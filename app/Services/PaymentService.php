<?php

namespace App\Services;

use App\Helpers\TextSystemConst;
use App\Http\Requests\Admin\UpdatePaymentRequest;
use App\Models\Payment;
use App\Repository\Eloquent\PaymentRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentService 
{
    /**
     * @var PaymentRepository
     */
    private $paymentRepository;

    /**
     * PaymentService constructor.
     *
     * @param PaymentRepository $paymentRepository
     */
    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get list payments
        $list = $this->paymentRepository->all();
        $tableCrud = [
            'headers' => [
                [
                    'text' => 'Mã PTTT',
                    'key' => 'id',
                ],
                [
                    'text' => 'Phương Thức Thanh Toán',
                    'key' => 'name',
                ],
                [
                    'text' => 'Trạng Thái',
                    'key' => 'status',
                    'status' => [
                        [
                            'text' => 'Hoạt động',
                            'value' => Payment::STATUS['active'],
                            'class' => 'badge badge-success'
                        ],
                        [
                            'text' => 'Vô hiệu hóa',
                            'value' => Payment::STATUS['unactive'],
                            'class' => 'badge badge-danger'
                        ],
                    ],
                ],
                [
                    'text' => 'Hình Ảnh',
                    'key' => 'img',
                    'img' => [
                        'url' => 'asset/imgs/',
                        'style' => 'width: 60px;'
                    ],
                ],
            ],
            'actions' => [
                'text'          => "Thao Tác",
                'create'        => false,
                'createExcel'   => false,
                'edit'          => true,
                'deleteAll'     => false,
                'delete'        => false,
                'viewDetail'    => false,
            ],
            'routes' => [
                'edit' => 'admin.payments_edit',
            ],
            'list' => $list,
        ];

        return [
            'title' => TextLayoutTitle("payment_method"),
            'tableCrud' => $tableCrud,
        ];
    }

    public function edit(Payment $payment)
    {
        try {
            // Fields form
            $status = [
                [
                    'text' => 'Hoạt động',
                    'value' => 1,
                ],
                [
                    'text' => 'Vô hiệu hóa',
                    'value' => 0,
                ]
            ];
            $fields = [
                [
                    'attribute' => 'name',
                    'label' => 'Tên Phương Thức',
                    'type' => 'text',
                    'value' => $payment->name,
                ],
                [
                    'attribute' => 'status',
                    'label' => 'Trạng Thái',
                    'type' => 'select',
                    'value' => $payment->status,
                    'list' => $status
                ],
                [
                    'attribute' => 'img',
                    'label' => 'Hình ảnh',
                    'type' => 'file',
                    'value' => $payment->img,
                ],
            ];
    
            //Rules form
            $rules = [
                'name' => [
                    'required' => true,
                    'minlength' => 1,
                    'maxlength' => 100,
                ],
            ];
    
            // Messages eror rules
            $messages = [
                'name' => [
                    'required' => __('message.required', ['attribute' => 'Tên danh mục']),
                    'minlength' => __('message.min', ['min' => 1, 'attribute' => 'Tên danh mục']),
                    'maxlength' => __('message.max', ['max' => 100, 'attribute' => 'Tên danh mục']),
                ],
            ];
    
            return [
                'title' => TextLayoutTitle("edit_payment"),
                'fields' => $fields,
                'rules' => $rules,
                'messages' => $messages,
                'payment' => $payment,
            ];
        } catch (Exception) {
            return [];
        }
        
    }

    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        try {
            $data = $request->validated();
            if ($request->img) {
                $imageName = time().'.'.request()->img->getClientOriginalExtension();
                request()->img->move(public_path('asset/imgs'), $imageName);
                $data['img'] = $imageName;
            }
            $this->paymentRepository->update($payment, $data);

            return redirect()->route('admin.payments_index')->with('success', TextSystemConst::UPDATE_SUCCESS);
        } catch (Exception $e) {
            return redirect()->route('admin.payments_index')->with('error', TextSystemConst::UPDATE_FAILED);
        }
    }

}
?>