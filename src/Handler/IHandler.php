<?php

declare(strict_types=1);

namespace Imi\Email\BlackList\Handler;

interface IHandler
{
    /**
     * @param string[] $domains
     */
    public function add(array $domains): int;

    /**
     * @param string[] $domains
     */
    public function remove(array $domains): int;

    public function has(string $domain): bool;

    public function clear(): void;

    /**
     * @return string[]
     */
    public function list(string $search = '', ?int $page = null, ?int $count = null): array;

    public function count(): int;
}
