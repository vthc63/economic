<?php

namespace App\Repository\Eloquent;

use App\Models\Role;
use App\Models\User;
use App\Repository\UserRepositoryInterface;

/**
 * Class UserRepository
 * @package App\Repositories\Eloquent
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    /**
     * Get all of the users from the database
     */
    public function all()
    {
        return $this->model
            ->where(['role_id' => Role::ROLE['user']])
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function admins()
    {
        return $this->model
            ->where('role_id', '!=', Role::ROLE['user'])
            ->orderBy('id', 'DESC')
            ->get();
    }
}

?>