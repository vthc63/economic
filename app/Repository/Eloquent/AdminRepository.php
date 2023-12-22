<?php

namespace App\Repository\Eloquent;

use App\Models\Admin;
use App\Models\Role;
use App\Repository\AdminRepositoryInterface;

/**
 * Class AdminRepository
 * @package App\Repositories\Eloquent
 */
class AdminRepository extends BaseRepository implements AdminRepositoryInterface
{
    /**
     * AdminRepository constructor.
     *
     * @param Admin $admin
     */
    public function __construct(Admin $admin)
    {
        parent::__construct($admin);
    }
}

?>