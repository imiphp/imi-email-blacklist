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
    public function list(string $search = '', ?int $page = null, ?int $count = null): array
    {
        if ('' === $search && null === $page && null === $count)
        {
            return Redis::use(fn (RedisRedisHandler $redis) => $redis->sMembers($this->key));
        }

        $pattern = '' === $search ? '*' : ('*' . $search . '*');

        return Redis::use(fn (RedisRedisHandler $redis) => $redis->eval(<<<LUA
        local key = KEYS[1]
        local page = tonumber(ARGV[1])
        local pattern = ARGV[2]
        local count = tonumber(ARGV[3])
        local it = 0
        local result = {}
        local i = 1
        while i <= page do
            it, result = unpack(redis.call('sscan', key, it, 'MATCH', pattern, 'COUNT', count))
            if '0' == it then
                if i == page then
                    break
                else
                    return {}
                end
            elseif #result > 0 then
                i = i + 1
            end
        end
        return result
        LUA, [$this->key, $page ?? 1, $pattern, $count ?? 100], 1) ?: []);
    }

    public function count(): int
    {
        return Redis::use(fn (RedisRedisHandler $redis) => $redis->scard($this->key));
    }
}
