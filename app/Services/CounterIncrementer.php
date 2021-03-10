<?php

namespace App\Services;

class CounterIncrementer
{
    private $redis;

    public function __construct()
    {
        $this->redis = app('redis');
    }

    /**
     * @param string $code
     */
    public function incrementByCode(string $code): void
    {
        if ($this->redis->exists($code)) {
            $this->redis->incr($code);
            return;
        }

        $this->redis->set($code, 1);
    }
}
