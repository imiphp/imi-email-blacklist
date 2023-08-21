<?php

declare(strict_types=1);

namespace Imi\Email\BlackList\Cron;

use Imi\App;
use Imi\Cron\Annotation\Cron;
use Imi\Cron\Contract\ICronTask;
use Imi\Email\BlackList\EmailBlackListCrawler;

/**
 * @Cron(id="UpdateEmailBlackListCron", hour="1n", minute="0", second="0", type="random_worker")
 */
class UpdateEmailBlackListCron implements ICronTask
{
    /**
     * 执行任务
     */
    public function run(string $id, $data): void
    {
        App::getBean(EmailBlackListCrawler::class)->crawl();
    }
}
