<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\RedisService;

class Coaster extends ResourceController
{
    public const ID_KEY = 'coaster';

    private RedisService $redis;

    public function __construct()
    {
        $this->redis = service('redisService');
    }

    public function create()
    {
        $coaster = $this->request->getJSON(true);

        if (!isset(
            $coaster['liczba_personelu'],
            $coaster['liczba_klientow'],
            $coaster['dl_trasy'],
            $coaster['godziny_od'],
            $coaster['godziny_do'])
        ) {
            return $this->fail('Brakuje wymaganych danych.', ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
        }

        $coasterId = $this->redis->incr(sprintf('incr_%s:id', self::ID_KEY));
        $coasterKey = sprintf('%s:%s', self::ID_KEY, $coasterId);
        $coaster['id'] = $coasterId;
        $coaster['wagons'] = [];
        $this->redis->set($coasterKey, json_encode($coaster));

        log_message('info', sprintf('Kolejka została utworzona id: %s.', $coasterId));

        return $this->respondCreated([
            'message' => 'Kolejka została utworzona.',
            'coaster_id' => $coasterId
        ]);
    }

    public function update($id = null)
    {
        $coasterKey = sprintf('%s:%s', self::ID_KEY, $id);

        if (!$this->redis->exists($coasterKey)) {
            return $this->failNotFound('Kolejka nie istnieje.');
        }

        $coaster = json_decode($this->redis->get($coasterKey), true);
        $updateData = $this->request->getJSON(true);

        if (!empty($updateData['dl_trasy'])) {
            unset($updateData['dl_trasy']);
        }

        $coaster = array_merge($coaster, $updateData);

        $this->redis->set($coasterKey, json_encode($coaster));

        log_message('info', sprintf('Kolejka została zmodyfikowana id: %s.', $id));

        return $this->respondUpdated(['message' => 'Kolejka została zmodyfikowana.']);
    }
}