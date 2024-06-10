<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

Interface BaseRepositoryInterface
{
    public function all();

    public function get(int $id);

    public function save(Model $model);
}
