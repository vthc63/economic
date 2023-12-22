<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ProductSize extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products_size';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_color_id',
        'size_id ',
        'quantity',
    ];

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id', 'id')->setEagerLoads([]);
    }

    public function productColor()
    {
        return $this->belongsTo(ProductColor::class, 'product_color_id', 'id')->setEagerLoads([]);
    }
}
