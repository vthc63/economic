<?php

namespace App\Repository\Eloquent;

use App\Models\Product;
use App\Repository\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;

/**
 * Class ProductRepository
 * @package App\Repositories\Eloquent
 */
class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    /**
     * ProductRepository constructor.
     *
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        parent::__construct($product);
    }

    public function all()
    {
        return Product::join('categories', 'products.category_id', '=', 'categories.id')
        ->selectRaw('products.*')
        ->whereNull('categories.deleted_at')->orderByDesc('products.id')
        ->get();
    }

    /**
     * Get best selling product
     */
    public function getBestSellingProduct()
    {
        return DB::select('
            select sum(order_details.quantity) as sum, products.id, products.name, products.price_sell, products.img from products 
            join products_color on products.id = products_color.product_id
            join products_size on products_color.id = products_size.product_color_id
            join order_details on products_size.id = order_details.product_size_id
            join orders on orders.id = order_details.order_id
            where orders.order_status = 3 and products.deleted_at is null
            group by products.id, products.name, products.price_sell, products.img
            order by sum desc
            limit 12
        ');
    }

    /**
     * Get new products
     */
    public function getNewProducts()
    {
        return $this->model
        ->join('categories', 'products.category_id', '=', 'categories.id')->whereNull('categories.deleted_at')
        ->selectRaw('products.*')
        ->orderBy("products.id", "desc")->limit(12)->get();
    }

    public function getQuantityBuyProduct($productId)
    {
        return DB::select("
            select sum(order_details.quantity) as sum from products 
            join products_color on products.id = products_color.product_id
            join products_size on products_color.id = products_size.product_color_id
            join order_details on products_size.id = order_details.product_size_id
            join orders on orders.id = order_details.order_id
            where orders.order_status = 3 
            and products.deleted_at is null
            and products.id = $productId
        ")[0]->sum ?? 0;
    }

    /**
     * Get total product sold by id
     * @param int $id
     */
    public function getTotalProductSoldById($id)
    {
        return DB::select("
            select sum(order_details.quantity) as sum,
            products.id, products.name, products.price_sell, products.description, products.img
            from products
            join products_color on products.id = products_color.product_id
            join products_size on products_color.id = products_size.product_color_id
            join order_details on products_size.id = order_details.product_size_id
            join orders on orders.id = order_details.order_id
            where orders.order_status = 3 and products.id = $id
            group by products.id, products.name, products.price_sell, products.description, products.img;
        ")[0] ?? null;
    }

    public function getProductSearch($keyword = null, $category = null, $minPrice = null, $maxPrice = null, $brand = null)
    {
        return $this->model->when($keyword, function($query, $keyword){
            return $query->where('products.name', 'LIKE', '%' . $keyword . '%');
        })
        ->when($category, function($query, $category){
            return $query->where('products.category_id', $category);
        })
        ->when($minPrice, function ($query, $minPrice) {
            return $query->where('products.price_sell', '>=', $minPrice);
        })
        ->when($maxPrice, function ($query, $maxPrice) {
            return $query->where('products.price_sell', '<=', $maxPrice);
        })
        ->when($brand, function ($query, $brand) {
            return $query->where('products.brand_id', $brand);
        })
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->selectRaw('products.*')
        ->whereNull('categories.deleted_at')
        ->paginate(Product::PRODUCT_NUMBER_ITEM['search'])
        ->withQueryString();
    }

    public function getProductBySlug($slug, $brand, $minPrice, $maxPrice)
    {
        return $this->model
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->selectRaw('products.*')
        ->where('categories.slug', $slug)
        ->when($brand, function ($query, $brand) {
            return $query->where('products.brand_id', $brand);
        })
        ->when($minPrice, function ($query, $minPrice) {
            return $query->where('products.price_sell', '>=', $minPrice);
        })
        ->when($maxPrice, function ($query, $maxPrice) {
            return $query->where('products.price_sell', '<=', $maxPrice);
        })
        ->orderByDesc('products.id')
        ->paginate(Product::PRODUCT_NUMBER_ITEM['show'])
        ->withQueryString();
        ;
    }

    public function getRelatedProducts($product)
    {
        return $this->model
        ->where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->orderByDesc('id')
        ->limit(4)
        ->get();
    }

    public function checkProductColorExist($productId, $color)
    {
        return $this->model->join('products_color', 'products_color.product_id', '=', 'products.id')
        ->where('products.id', $productId)->where('products_color.color_id', $color)
        ->whereNull('products_color.deleted_at')
        ->count();
    }
}

?>