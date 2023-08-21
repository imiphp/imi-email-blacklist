<?php

declare(strict_types=1);

namespace Imi\Email\BlackList\Test;

use Imi\App;
use Imi\Config;
use Imi\Email\BlackList\EmailBlackListCrawler;
use PHPUnit\Framework\TestCase;

class CrawlerTest extends TestCase
{
    /**
     * @var string[]
     */
    protected array $crawlers = [
        \Imi\Email\BlackList\IvoloDisposableEmailDomainsCrawler::class,
    ];

    public function testCrawler(): void
    {
        $beansConfigName = '@app.beans.' . EmailBlackListCrawler::class . '.crawlers';
        $originConfig = Config::get($beansConfigName, []);
        foreach ($this->crawlers as $crawlerClass)
        {
            Config::set($beansConfigName, [$crawlerClass]);
            $crawler = App::newInstance(EmailBlackListCrawler::class);
            $this->assertGreaterThanOrEqual(0, $crawler->crawl());
        }
        Config::set($beansConfigName, $originConfig);
    }
}
