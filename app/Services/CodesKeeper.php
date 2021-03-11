<?php

namespace App\Services;

use App\Exceptions\RedisKeyNotFound;

class CodesKeeper
{
    private $redis;

    public function __construct()
    {
        $this->redis = app('redis');
    }

    /**
     * @param string $code
     */
    public function keep(string $code): void
    {
        $codesJson = $this->redis->get('codes');
        if (!$codesJson) {
            $this->redis->set('codes', json_encode([$code]));
            return;
        }

        $codes = json_decode($codesJson);
        if (!in_array($code, $codes)) {
            $codes[] = $code;
            $this->redis->set('codes', json_encode($codes));
        }
    }

    /**
     * @return array
     * @throws RedisKeyNotFound
     */
    public function getStats(): array
    {
        $encodeCodes = $this->redis->get('codes');
        if (!$encodeCodes) {
            throw new RedisKeyNotFound('Key `codes` not found', 409);
        }

        $codes = json_decode($encodeCodes);
        $counts = $this->redis->mget($codes);

        $result = [];
        foreach ($codes as $i => $code) {
            if (!$counts[$i]) {
                continue;
            }

            $result[$code] = $counts[$i];
        }

        return $result;
    }
}
