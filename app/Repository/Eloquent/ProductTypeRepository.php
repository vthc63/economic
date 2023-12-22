<?php

namespace App\Repository\Eloquent;

use App\Models\ProductType;
use App\Models\Size;

/**
 * Class ProductTypeRepository
 * @package App\Repositories\Eloquent
 */
class ProductTypeRepository extends BaseRepository
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

}

?>