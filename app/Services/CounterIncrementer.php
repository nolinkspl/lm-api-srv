<?php

namespace App\Services;

class CounterIncrementer
{
    private $redis;
    private $codesKeeper;

    public function __construct(CodesKeeper $codesKeeper)
    {
        $this->redis = app('redis');
        $this->codesKeeper = $codesKeeper;
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

        $this->codesKeeper->keep($code);
        $this->redis->set($code, 1);
    }
}
