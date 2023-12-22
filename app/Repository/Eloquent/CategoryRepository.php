<?php

namespace App\Repository\Eloquent;

use App\Models\Category;

/**
 * Class CategoryRepository
 * @package App\Repositories\Eloquent
 */
class CategoryRepository extends BaseRepository
{
    /**
     * CategoryRepository constructor.
     *
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }
}

?>