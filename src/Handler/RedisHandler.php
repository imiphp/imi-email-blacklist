<?php

declare(strict_types=1);

namespace Imi\Email\BlackList\Handler;

use Imi\Redis\Redis;
use Imi\Redis\RedisHandler as RedisRedisHandler;

class RedisHandler implements IHandler
{
    protected string $key = 'imi:email:blacklist';

    protected ?string $poolName = null;

    /**
     * @param string[] $domains
     */
    public function add(array $domains): int
    {
        return Redis::use(fn (RedisRedisHandler $redis) => $redis->sAdd($this->key, ...$domains));
    }

    /**
     * @param string[] $domains
     */
    public function remove(array $domains): int
    {
        return Redis::use(fn (RedisRedisHandler $redis) => $redis->srem($this->key, ...$domains));
    }

    public function has(string $domain): bool
    {
        return Redis::use(fn (RedisRedisHandler $redis) => $redis->sismember($this->key, $domain));
    }

    public function clear(): void
    {
        Redis::use(fn (RedisRedisHandler $redis) => $redis->del($this->key));
    }

    /**
     * @return string[]
     */
    public function list(): array
    {
        return Redis::use(fn (RedisRedisHandler $redis) => $redis->sMembers($this->key) ?: []);
    }

    public function count(): int
    {
        return Redis::use(fn (RedisRedisHandler $redis) => $redis->scard($this->key));
    }
}
