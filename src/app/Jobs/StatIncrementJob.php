<?php

namespace App\Jobs;

use App\Services\CounterIncrementer;

class StatIncrementJob extends Job
{
    private $code;

    /**
     * StatIncrementJob constructor.
     * @param string $code
     */
    public function __construct(string $code)
    {
        $this->code = $code;
    }

    /**
     * @param CounterIncrementer $incrementer
     */
    public function handle(CounterIncrementer $incrementer)
    {
        $incrementer->incrementByCode($this->code);
    }
}
