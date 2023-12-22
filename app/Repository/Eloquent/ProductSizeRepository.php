<?php

namespace App\Repository\Eloquent;

use App\Models\ProductType;
use Illuminate\Support\Facades\DB;

/**
 * Class ProductSizeRepository
 * @package App\Repositories\Eloquent
 */
class ProductSizeRepository extends BaseRepository
{
    /**
     * ProductTypeRepository constructor.
     *
     * @param ProductType $productType
     */
    public function __construct(ProductType $productType)
    
    {
        parent::__construct($productType);
    }
    public function getProductSize($id)
    {
        return DB::table('products_size')
        ->join('products_color', 'products_size.product_color_id', '=', 'products_color.id')
        ->join('products', 'products.id', '=', 'products_color.product_id')
        ->join('colors', 'products_color.color_id', '=', 'colors.id')
        ->join('sizes', 'sizes.id', '=', 'products_size.size_id')
        ->select(
            'products_color.img as product_img',
            'products.name as product_name',
            'colors.name as color_name',
            'sizes.name as size_name',
            'products.price_sell as product_price_sell',
            'products_size.quantity as products_size_quantity'
        )
        ->where('products_size.id', $id)->first();
    }
}

?>