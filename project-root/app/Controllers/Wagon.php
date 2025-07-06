<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\RedisService;

class Wagon extends ResourceController
{
    public const ID_KEY = 'wagon';

    private RedisService $redis;

    public function __construct()
    {
        $this->redis = service('redisService');
    }

    public function create($coasterId = null)
    {
        if (!$coasterId) {
            return $this->fail('Brak parametru ID w URL.', ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
        }

        $coasterKey = sprintf('%s:%s', Coaster::ID_KEY, $coasterId);

        if (!$this->redis->exists($coasterKey)) {
            return $this->failNotFound('Coaster does not exists.');
        }

        $wagon = $this->request->getJSON(true);

        if (!isset($wagon['ilosc_miejsc'], $wagon['predkosc_wagonu'])) {
            return $this->fail('Brakuje wymaganych danych.', ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
        }

        $wagonId = $this->redis->incr(sprintf('incr_%s:%s:incr_%s:id', Coaster::ID_KEY, $coasterId, self::ID_KEY));
        $wagonKey = sprintf('%s:%s', self::ID_KEY, $wagonId);
        $wagon['id'] = $wagonId;

        $coaster = json_decode($this->redis->get($coasterKey), true);
        $coaster['wagons'][$wagonKey] = $wagon;

        $this->redis->set($coasterKey, json_encode($coaster));

        log_message('info', sprintf('Wagonik została zmodyfikowany id: %s, kolejka id: %s.', $wagonId, $coasterId));

        return $this->respondCreated([
            'message' => 'Wagon został utworzony.',
            'coaster_id' => (int)$coasterId,
            'wagon_id' => $wagonId
        ]);
    }

    public function remove($coasterId = null, $wagonId = null)
    {
        $coasterKey = sprintf('%s:%s', Coaster::ID_KEY, $coasterId);

        if (!$this->redis->exists($coasterKey)) {
            return $this->failNotFound('Kolejka o podanym id nie istnieje.');
        }

        $coaster = json_decode($this->redis->get($coasterKey), true);
        $wagonKey = sprintf('%s:%s', self::ID_KEY, $wagonId);

        if (!isset($coaster['wagons'][$wagonKey])) {
            return $this->failNotFound('Wagon o podanym id nie istnieje.');
        }

        unset($coaster['wagons'][$wagonKey]);

        $this->redis->set($coasterKey, json_encode($coaster));

        log_message('info', sprintf('Wagonik została usunięty id: %s, kolejka id: %s.', $wagonId, $coasterId));

        return $this->respondDeleted(['message' => 'Wagon został usunięty.']);
    }
}