<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Product extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'price_import',
        'price_sell',
        'img',
        'description',
        'status',
        'category_id',
        'brand_id',
    ];

    const PRODUCT_NUMBER_ITEM = [
        'search' => 24,
        'show' => 6,
    ];

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'products_color');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id')->setEagerLoads([]);

    }
}
