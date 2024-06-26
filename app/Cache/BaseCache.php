<?php

namespace App\Cache;

use App\Contracts\BaseRepositoryInterface;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Cache;

abstract class BaseCache implements BaseRepositoryInterface
{
    const TTL= 60 * 60 * 24;
    protected $repository;
    protected $key;
    protected $cache;

    public function __construct(BaseRepository $repository, string $key)
    {
        $this->repository = $repository;
        $this->key = $key;
        $this->cache = new Cache();
    }
}
