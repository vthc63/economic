<?php

namespace App\Repository\Eloquent;

use App\Models\Payment;

/**
 * Class PaymentRepository
 * @package App\Repositories\Eloquent
 */
class PaymentRepository extends BaseRepository
{
    /**
     * PaymentRepository constructor.
     *
     * @param Payment $payment
     */
    public function __construct(Payment $payment)
    {
        parent::__construct($payment);
    }
}

?>