<?php

declare(strict_types=1);

namespace Imi\Email\BlackList;

use Imi\Email\BlackList\Contract\IEmailBlackListCrawler;
use Yurun\Util\HttpRequest;

class IvoloDisposableEmailDomainsCrawler implements IEmailBlackListCrawler
{
    protected string $url = 'https://ghproxy.com/https://github.com/ivolo/disposable-email-domains/raw/master/index.json';

    protected int $maxBatchSize = 1000;

    /**
     * @return \Iterator<string>
     */
    public function crawl(): \Iterator
    {
        $http = new HttpRequest();
        $list = $http->get($this->url)->json(true);
        if (!$list)
        {
            throw new \RuntimeException('Failed to get email domains list');
        }
        yield from $list;
    }

    public function getMaxBatchSize(): int
    {
        return $this->maxBatchSize;
    }
}
