<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Order extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'payment_id',
        'user_id',
        'total_money',
        'order_status',
        'transport_fee',
        'note',
        'payment_status',
    ];

    const STATUS_ORDER = [
        'wait' => 0,
        'transporting' => 1,
        'cancel' => 2,
        'received' => 3,
    ];

    const PAYMENT_STATUS = [
        'unpaid' => 0,
        'paid' => 1,
    ];

    const ORDER_NUMBER_ITEM = [
        'history' => 10,
    ];
}
