<?php

declare(strict_types=1);

namespace Imi\Email\BlackList\Command;

use Imi\App;
use Imi\Cli\Annotation\Command;
use Imi\Cli\Annotation\CommandAction;
use Imi\Cli\Contract\BaseCommand;
use Imi\Email\BlackList\EmailBlackListCrawler;

/**
 * @Command("emailBlackList")
 */
class EmailBlackListCommand extends BaseCommand
{
    /**
     * @CommandAction("crawl")
     */
    public function crawl(): void
    {
        App::getBean(EmailBlackListCrawler::class)->crawl();
    }
}
