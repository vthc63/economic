<?php

namespace App\Repository\Eloquent;

use App\Models\Address;
use App\Repository\AddressRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AddressRepository
 * @package App\Repositories\Eloquent
 */
class AddressRepository extends BaseRepository implements AddressRepositoryInterface
{
    /**
     * AddressRepository constructor.
     *
     * @param Address $address
     */
    public function __construct(Address $address)
    {
        parent::__construct($address);
    }

    /**
     * create or update user model in the database.
     * 
     * @param array $attributes
     * @return Model
     */
    public function updateOrCreate(array $attributes): Model
    {
        return $this->model->updateOrCreate($attributes);
    }
}

?>