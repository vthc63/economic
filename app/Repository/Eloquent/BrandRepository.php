<?php

namespace App\Repository\Eloquent;

use App\Models\Brand;
use App\Models\Color;

/**
 * Class BrandRepository
 * @package App\Repositories\Eloquent
 */
class BrandRepository extends BaseRepository
{
    /**
     * BrandRepository constructor.
     *
     * @param Brand $brand
     */
    public function __construct(Brand $brand)
    {
        parent::__construct($brand);
    }
}

?>