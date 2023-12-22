<?php

namespace App\Repository\Eloquent;

use App\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRepository
 * @package App\Repositories\Eloquent
 */
class BaseRepository implements BaseRepositoryInterface 
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /** 
     * create the model in the database.
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /** 
     * Update the model in the database.
     * @param array $attributes
     *
     * @return bool
     */
    public function update(Model $model, array $attributes): bool
    {
        return $model->update($attributes);
    }

    /**
     * Find the models for the given IDs
     * @param $id
     *
     * @return Model
     */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Destroy the models for the given IDs.
     * @param $ids
     * @return int
     */
    public function destroy($ids): int 
    {
        return $this->model->destroy($ids);
    }

    /**
     * Get all from the database
     */
    public function all()
    {
        return $this->model->all();
    }

     /**
     * Delete the models for database.
     * @return bool
     */
    public function delete(Model $model): bool 
    {
        return $model->delete();
    }

    /**
     * Get all of the users from the database
     */
    public function where($attributes)
    {
        return $this->model->where($attributes)->get();
    }

    /**
     * Get all of the users from the database
     */
    public function whereFirst($attributes)
    {
        return $this->model->where($attributes)->first();
    }
}
?>