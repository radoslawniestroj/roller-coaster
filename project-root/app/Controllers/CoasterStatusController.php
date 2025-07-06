<?php

namespace App\Controllers;

use App\Libraries\RedisService;
use App\Services\CoasterStatsService;
use CodeIgniter\RESTful\ResourceController;

class CoasterStatusController extends ResourceController
{
    private RedisService $redis;
    protected CoasterStatsService $statsService;

    public function __construct()
    {
        $this->redis = service('redisService');
        $this->statsService = new CoasterStatsService();
    }

    public function show($id = null)
    {
        $coasterKey = sprintf('%s:%s', Coaster::ID_KEY, $id);

        if (!$this->redis->exists($coasterKey)) {
            return $this->failNotFound(sprintf("Kolejka o ID %s nie istnieje.", $id));
        }

        $coaster = json_decode($this->redis->get($coasterKey), true);
        $status = $this->statsService->evaluateCoaster($coaster);

        return $this->respond($status);
    }
}