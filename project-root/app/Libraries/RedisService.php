<?php

namespace App\Libraries;

use Redis;

class RedisService
{
    protected Redis $redis;

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('redis', 6379);
        $db = ENVIRONMENT === 'production' ? 1 : 0;
        $this->redis->select($db);
    }

    public function set(string $key, string $value, ?int $ttl = null)
    {
        return $ttl
            ? $this->redis->setex($key, $ttl, $value)
            : $this->redis->set($key, $value);
    }

    public function get(string $key)
    {
        return $this->redis->get($key) ?: null;
    }

    public function delete(string $key)
    {
        return $this->redis->del($key) > 0;
    }

    public function incr(string $key)
    {
        return $this->redis->incr($key);
    }

    public function exists(string $key)
    {
        return $this->redis->exists($key);
    }

    public function keys(string $key)
    {
        return $this->redis->keys($key);
    }
}