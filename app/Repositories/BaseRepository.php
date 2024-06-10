<?php

namespace App\Repositories;

use App\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;
    private $relations;


    public function __construct(Model $model, array $relations = [])
    {
        $this->model = $model;
        $this->relations = $relations;
    }

    public function all()
    {
        $query = $this->model;
        if(!empty($this->relations)) {
            $query = $query->with($this->relations);
        }
        return $query->get();
    }

    public function get(int $id)
    {
        $query = $this->model->find($id);
        if(!empty($this->relations)) {
            $query = $query->with($this->relations);
        }
        return $query;
    }

    public function save(Model $model)
    {
        $model->save();
        return $model;
    }
}
