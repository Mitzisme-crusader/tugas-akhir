<?php

namespace App\Repository\Eloquent;

use App\Repository\eloquent_repository_interface;
use App\Repository\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class base_repository implements eloquent_repository_interface
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
    * @param array $attributes
    *
    * @return Model
    */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
    * @param $id
    * @return Model
    */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    public function all()
    {
        return $this->model->all();
    }
}
