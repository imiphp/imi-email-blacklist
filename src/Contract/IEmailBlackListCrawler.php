<?php

declare(strict_types=1);

namespace Imi\Email\BlackList\Contract;

interface IEmailBlackListCrawler
{
    /**
     * @return \Iterator<string>
     */
    public function crawl(): \Iterator;

    public function getMaxBatchSize(): int;
}
