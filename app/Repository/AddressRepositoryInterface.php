<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface AddressRepositoryInterface
 * @package App\Repositories
 */
interface AddressRepositoryInterface
{
    /**
     * create or update address model in the database.
     * 
     * @param array $attributes
     * @return Model
     */
    public function updateOrCreate(array $attributes): Model;
}
?>