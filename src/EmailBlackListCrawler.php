<?php

declare(strict_types=1);

namespace Imi\Email\BlackList;

use Imi\Aop\Annotation\Inject;
use Imi\App;
use Imi\Email\BlackList\Contract\IEmailBlackListCrawler;
use Imi\Log\Log;

class EmailBlackListCrawler
{
    /**
     * @var string[]
     */
    protected array $crawlers = [
        \Imi\Email\BlackList\IvoloDisposableEmailDomainsCrawler::class,
    ];

    protected bool $enable = true;

    /**
     * @Inject
     */
    protected EmailBlackListHandler $handler;

    public function crawl(): int
    {
        if (!$this->isEnable())
        {
            return 0;
        }
        Log::info('开始采集邮箱黑名单');
        $totalDomainCount = 0;
        foreach ($this->getCrawlers() as $crawlerClass)
        {
            $totalDomainCount += $this->crawlClass($crawlerClass);
        }
        Log::info('完成采集邮箱黑名单，新增域名数量：' . $totalDomainCount . '个');

        return $totalDomainCount;
    }

    protected function crawlClass(string $class): int
    {
        Log::info('开始采集邮箱黑名单：' . $class);
        /** @var IEmailBlackListCrawler $crawler */
        $crawler = App::getBean($class);
        $maxBatchSize = $crawler->getMaxBatchSize();
        $domains = [];
        $domainCount = 0;
        $totalDomainCount = 0;
        foreach ($crawler->crawl() as $domain)
        {
            $domains[] = $domain;
            ++$domainCount;
            if ($domainCount >= $maxBatchSize)
            {
                $totalDomainCount += $this->handler->getInstance()->add($domains);
                $domains = [];
                $domainCount = 0;
            }
        }
        if ($domainCount > 0)
        {
            $totalDomainCount += $this->handler->getInstance()->add($domains);
        }

        return $totalDomainCount;
    }

    public function getCrawlers(): array
    {
        return $this->crawlers;
    }

    public function isEnable(): bool
    {
        return $this->enable;
    }
}
