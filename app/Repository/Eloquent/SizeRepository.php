<?php

namespace App\Repository\Eloquent;

use App\Models\Size;

/**
 * Class SizeRepository
 * @package App\Repositories\Eloquent
 */
class SizeRepository extends BaseRepository
{
    /**
     * SizeRepository constructor.
     *
     * @param Size $size
     */
    public function __construct(Size $size)
    {
        parent::__construct($size);
    }
}

?>