<?php

namespace App\Cache;

use App\Repositories\ApplicantRepository;
use Illuminate\Database\Eloquent\Model;

class ApplicantCache extends BaseCache
{
    public function __construct(ApplicantRepository $applicantRepository) {
        parent::__construct($applicantRepository, key: 'applicant');
    }


    public function all()
    {
        return $this->cache::remember($this->key, self::TTL, function(){
            return $this->repository->all();
        });
    }

    public function get(int $id)
    {
        return $this->repository->get($id);
    }

    public function save(Model $model)
    {
        $this->cache::forget($this->key);
        return $this->repository->save($model);
    }
}
