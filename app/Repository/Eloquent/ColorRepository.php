<?php

namespace App\Repository\Eloquent;

use App\Models\Color;

/**
 * Class ColorRepository
 * @package App\Repositories\Eloquent
 */
class ColorRepository extends BaseRepository
{
    /**
     * ColorRepository constructor.
     *
     * @param Color $color
     */
    public function __construct(Color $color)
    {
        parent::__construct($color);
    }
}

?>