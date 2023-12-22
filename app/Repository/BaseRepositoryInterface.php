<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface BaseRepositoryInterface
 * @package App\Repositories
 */
interface BaseRepositoryInterface
{
    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param $id
     * @return Model
     */
    public function find($id): ?Model;

   /**
    * Destroy the models for the given IDs.
    *
    * @param $id
    * @return int
    */
    public function destroy($id): int;

    /**
    * @param array $attributes
    * @return Model
    */
    public function update(Model $model, array $attributes): bool;

    /**
     * Get all of the users from the database
     */
    public function all();

    /**
     * Delete the models for the database.
     *  
     * @param Model
     * @return bool
     */
    public function delete(Model $model): bool;

    /**
     * Get all of the users from the database
     */
    public function where($attributes);
}
?>